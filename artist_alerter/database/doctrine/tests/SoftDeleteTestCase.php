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
 * Doctrine_SoftDelete_TestCase
 *
 * @package     Doctrine
 * @author      Konsta Vesterinen <kvesteri@cc.hut.fi>
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @category    Object Relational Mapping
 * @link        www.phpdoctrine.org
 * @since       1.0
 * @version     $Revision$
 */
class Doctrine_SoftDelete_TestCase extends Doctrine_UnitTestCase 
{
    public function prepareTables()
    {
        $this->tables[] = 'SoftDeleteTest';
        parent::prepareTables();
    }

    public function testDoctrineRecordDeleteSetsFlag()
    {
        Doctrine_Manager::getInstance()->setAttribute('use_dql_callbacks', true);
        $test = new SoftDeleteTest();
        $test->name = 'test';
        $test->something = 'test';
        $test->save();
        $test->delete();
        $this->assertTrue($test->deleted);
        $test->free();
        Doctrine_Manager::getInstance()->setAttribute('use_dql_callbacks', false);
    }

    public function testDoctrineQueryIsFilteredWithDeleteFlagCondition()
    {
        Doctrine_Manager::getInstance()->setAttribute('use_dql_callbacks', true);
        $q = Doctrine_Query::create()
                    ->from('SoftDeleteTest s')
                    ->where('s.name = ?', array('test'));

        $this->assertEqual($q->getSql(), 'SELECT s.name AS s__name, s.something AS s__something, s.deleted AS s__deleted FROM soft_delete_test s WHERE s.name = ? AND s.deleted = ?');
        $params = $q->getParams();
        $this->assertEqual(count($params), 2);
        $this->assertEqual($params[0], 'test');
        $this->assertEqual($params[1], false);

        $test = $q->fetchOne();
        $this->assertFalse($test);
        Doctrine_Manager::getInstance()->setAttribute('use_dql_callbacks', false);
    }

    public function testTicket1132()
    {
        Doctrine_Manager::getInstance()->setAttribute('use_dql_callbacks', true);
        $test = new SoftDeleteTest();
        $test->name = 'test1';
        $test->something = 'test2';
        $test->save();

        $q = Doctrine_Query::create()
                ->from('SoftDeleteTest s')
                ->addWhere('s.name = ?')
                ->addWhere('s.something = ?');

        $results = $q->execute(array('test1', 'test2'));
        $this->assertEqual($q->getSql(), 'SELECT s.name AS s__name, s.something AS s__something, s.deleted AS s__deleted FROM soft_delete_test s WHERE s.name = ? AND s.something = ? AND s.deleted = ?');
        $this->assertEqual($q->getParams(array('test1', 'test2')), array('test1', 'test2', false));
        $this->assertEqual($results->count(), 1);
        Doctrine_Manager::getInstance()->setAttribute('use_dql_callbacks', false);
    }

    // Test Doctrine_Query::count() applies dql hooks
    public function testTicket1170()
    {
        Doctrine_Manager::getInstance()->setAttribute('use_dql_callbacks', true);

        $q = Doctrine_Query::create()
                ->from('SoftDeleteTest s')
                ->addWhere('s.name = ?', 'test1')
                ->addWhere('s.something = ?', 'test2');

        $this->assertEqual($q->getCountQuery(), 'SELECT COUNT(DISTINCT s.name) AS num_results FROM soft_delete_test s WHERE s.name = ? AND s.something = ? AND s.deleted = ? GROUP BY s.name');
        $this->assertEqual($q->count(), 0);

        Doctrine_Manager::getInstance()->setAttribute('use_dql_callbacks', false);
    }
}