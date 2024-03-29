<?php
/*
 *  $Id$
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.phpdoctrine.org>.
 */

/**
 * Doctrine_Query_PgsqlSubquery_TestCase
 *
 * @package     Doctrine
 * @author      Konsta Vesterinen <kvesteri@cc.hut.fi>
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @category    Object Relational Mapping
 * @link        www.phpdoctrine.org
 * @since       1.0
 * @version     $Revision$
 */
class Doctrine_Query_PgsqlSubquery_TestCase extends Doctrine_UnitTestCase
{
    public function setUp()
    {
        $this->dbh = new Doctrine_Adapter_Mock('pgsql');
        $this->conn = Doctrine_Manager::getInstance()->openConnection($this->dbh);
    }

    public function testGetLimitSubqueryWithOrderByOnAggregateValues()
    {
        $q = new Doctrine_Query();
        $q->select('u.name, COUNT(DISTINCT a.id) num_albums');
        $q->from('User u, u.Album a');
        $q->orderby('num_albums');
        $q->groupby('u.id');
        $q->limit(5);

        $q->execute();

        $this->assertEqual($this->dbh->pop(), 'SELECT e.id AS e__id, e.name AS e__name, COUNT(DISTINCT a.id) AS a__0 FROM entity e LEFT JOIN album a ON e.id = a.user_id WHERE e.id IN '
                                             . '(SELECT doctrine_subquery_alias.id FROM '
                                             . '(SELECT DISTINCT e2.id, COUNT(DISTINCT a2.id) AS a2__0 FROM entity e2 LEFT JOIN album a2 ON e2.id = a2.user_id WHERE (e2.type = 0) GROUP BY e2.id ORDER BY a2__0 LIMIT 5) '
                                             . 'AS doctrine_subquery_alias) AND (e.type = 0) GROUP BY e.id ORDER BY a__0');

    }

    public function testGetLimitSubqueryWithOrderByOnAggregateValuesAndColumns()
    {
        $q = new Doctrine_Query();
        $q->select('u.name, COUNT(DISTINCT a.id) num_albums');
        $q->from('User u, u.Album a');
        $q->orderby('num_albums, u.name');
        $q->groupby('u.id');
        $q->limit(5);

        $q->execute();

        $this->assertEqual($this->dbh->pop(), 'SELECT e.id AS e__id, e.name AS e__name, COUNT(DISTINCT a.id) AS a__0 FROM entity e LEFT JOIN album a ON e.id = a.user_id WHERE e.id IN (SELECT doctrine_subquery_alias.id FROM (SELECT DISTINCT e2.id, e2.name, COUNT(DISTINCT a2.id) AS a2__0 FROM entity e2 LEFT JOIN album a2 ON e2.id = a2.user_id WHERE (e2.type = 0) GROUP BY e2.id ORDER BY a2__0, e2.name LIMIT 5) AS doctrine_subquery_alias) AND (e.type = 0) GROUP BY e.id ORDER BY a__0, e.name');
    }

}
