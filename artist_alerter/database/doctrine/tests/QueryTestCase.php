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
 * Doctrine_Query_TestCase
 *
 * @package     Doctrine
 * @author      Konsta Vesterinen <kvesteri@cc.hut.fi>
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @category    Object Relational Mapping
 * @link        www.phpdoctrine.org
 * @since       1.0
 * @version     $Revision$
 */
class Doctrine_Query_TestCase extends Doctrine_UnitTestCase 
{

    public function testGetQueryHookResetsTheManuallyAddedDqlParts()
    {
        $q = new MyQuery();

        $q->from('User u');

        $this->assertEqual($q->getQuery(), 'SELECT e.id AS e__id, e.name AS e__name, e.loginname AS e__loginname, e.password AS e__password, e.type AS e__type, e.created AS e__created, e.updated AS e__updated, e.email_id AS e__email_id FROM entity e WHERE e.id = 4 AND (e.type = 0)');

        // test consequent calls
        $this->assertEqual($q->getQuery(), 'SELECT e.id AS e__id, e.name AS e__name, e.loginname AS e__loginname, e.password AS e__password, e.type AS e__type, e.created AS e__created, e.updated AS e__updated, e.email_id AS e__email_id FROM entity e WHERE e.id = 4 AND (e.type = 0)');
    }


    public function testParseClauseSupportsArithmeticOperators()
    {
    	$q = new Doctrine_Query();

        $str = $q->parseClause('2 + 3');

        $this->assertEqual($str, '2 + 3');

        $str = $q->parseClause('2 + 3 - 5 * 6');

        $this->assertEqual($str, '2 + 3 - 5 * 6');
    }
    public function testParseClauseSupportsArithmeticOperatorsWithFunctions()
    {
    	$q = new Doctrine_Query();

        $str = $q->parseClause('ACOS(2) + 3');

        $this->assertEqual($str, 'ACOS(2) + 3');
    }

    public function testParseClauseSupportsArithmeticOperatorsWithParenthesis()
    {
    	$q = new Doctrine_Query();

        $str = $q->parseClause('(3 + 3)*3');

        $this->assertEqual($str, '(3 + 3)*3');

        $str = $q->parseClause('((3 + 3)*3 - 123) * 12 * (13 + 31)');

        $this->assertEqual($str, '((3 + 3)*3 - 123) * 12 * (13 + 31)');
    }

    public function testParseClauseSupportsArithmeticOperatorsWithParenthesisAndFunctions()
    {
    	$q = new Doctrine_Query();

        $str = $q->parseClause('(3 + 3)*ACOS(3)');

        $this->assertEqual($str, '(3 + 3)*ACOS(3)');

        $str = $q->parseClause('((3 + 3)*3 - 123) * ACOS(12) * (13 + 31)');

        $this->assertEqual($str, '((3 + 3)*3 - 123) * ACOS(12) * (13 + 31)');
    }

    public function testParseClauseSupportsComponentReferences()
    {
    	$q = new Doctrine_Query();
        $q->from('User u')->leftJoin('u.Phonenumber p');
        $q->getQuery();
        //Doctrine::dump($q->getCachedForm(array('foo' => 'bar')));
        $this->assertEqual($q->parseClause("CONCAT('u.name', u.name)"), "CONCAT('u.name', e.name)");
    }
    
    public function testCountMaintainsParams()
    {
        $q = new Doctrine_Query();
        $q->from('User u');
        $q->leftJoin('u.Phonenumber p');
        $q->where('u.name = ?', 'zYne');

        $this->assertEqual($q->count(), $q->execute()->count());
    }

    public function testCountWithGroupBy()
    {
        $q = new Doctrine_Query();
        $q->from('User u');
        $q->leftJoin('u.Phonenumber p');
        $q->groupBy('p.entity_id');

        $this->assertEqual($q->count(), $q->execute()->count());
    }

    // ticket #821
    public function testQueryCopyClone()
    {
        $query = new Doctrine_Query();
        $query->select('u.*')->from('User u');
        $sql = $query->getSql();
        
        $data = $query->execute();
        $query2 = $query->copy();
        
        $this->assertTrue($sql, $query2->getSql());
        
        $query2->limit(0);
        $query2->offset(0);
        $query2->select('COUNT(u.id) as nb');
        
        $this->assertTrue($query2->getSql(), 'SELECT COUNT(e.id) AS e__0 FROM entity e WHERE (e.type = 0)');
    }
    
    public function testNullAggregateIsSet()
    {
        $user = new User();
        $user->name = 'jon';
        $user->loginname = 'jwage';
        $user->Phonenumber[0]->phonenumber = new Doctrine_Expression('NULL');
        $user->save();
        $id = $user->id;
        $user->free();

        $query = Doctrine_Query::create()
                    ->select('u.*, p.*, SUM(p.phonenumber) summ')
                    ->from('User u')
                    ->leftJoin('u.Phonenumber p')
                    ->where('u.id = ?', $id);

        $users = $query->execute(array(), Doctrine::HYDRATE_ARRAY);

        $this->assertTrue(isset($users[0]['Phonenumber'][0]) && array_key_exists('summ', $users[0]['Phonenumber'][0]));
    }

    public function testQueryWithNoSelectFromRootTableThrowsException()
    {
        try {
            $users = Doctrine_Query::create()
                        ->select('p.*')
                        ->from('User u')
                        ->leftJoin('u.Phonenumber p')
                        ->execute();
            $this->fail();
        } catch (Doctrine_Query_Exception $e) {
            $this->pass();
        }
    }
    
    
    public function testOrQuerySupport()
    {
        $q1 = Doctrine_Query::create()
            ->select('u.id')
            ->from('User u')
            ->leftJoin('u.Phonenumber p')
            ->where('u.name = ?')
            ->orWhere('u.loginname = ?');
            
        $q2 = Doctrine_Query::create()
            ->select('u.id')
            ->from('User u')
            ->leftJoin('u.Phonenumber p')
            ->where('u.name = ? OR u.loginname = ?');

        $this->assertEqual(
            $q1->getSqlQuery(),
            'SELECT e.id AS e__id FROM entity e LEFT JOIN phonenumber p ON e.id = p.entity_id ' .
            'WHERE e.name = ? OR e.loginname = ? AND (e.type = 0)'
        );
        
        $items1 = $q1->execute(array('zYne', 'jwage'), Doctrine::HYDRATE_ARRAY);
        $items2 = $q2->execute(array('zYne', 'jwage'), Doctrine::HYDRATE_ARRAY);

        $this->assertEqual(count($items1), count($items2));
        
        $q1->free();
        $q2->free();
    }


    public function testOrQuerySupport2()
    {
        $q1 = Doctrine_Query::create()
            ->select('u.id')
            ->from('User u')
            ->leftJoin('u.Phonenumber p')
            ->where('u.name = ?')
            ->andWhere('u.loginname = ?')
            ->orWhere('u.id = ?');
            
        $q2 = Doctrine_Query::create()
            ->select('u.id')
            ->from('User u')
            ->leftJoin('u.Phonenumber p')
            ->where('(u.name = ? AND u.loginname = ?) OR (u.id = ?)');

        $this->assertEqual(
            $q1->getSqlQuery(),
            'SELECT e.id AS e__id FROM entity e LEFT JOIN phonenumber p ON e.id = p.entity_id ' .
            'WHERE e.name = ? AND e.loginname = ? OR e.id = ? AND (e.type = 0)'
        );
        
        $items1 = $q1->execute(array('jon', 'jwage', 4), Doctrine::HYDRATE_ARRAY);
        $items2 = $q2->execute(array('jon', 'jwage', 4), Doctrine::HYDRATE_ARRAY);

        $this->assertEqual(count($items1), count($items2));

        $q1->free();
        $q2->free();
    }
    
    
    public function testOrQuerySupport3()
    {
        $q1 = Doctrine_Query::create()
            ->select('u.id')
            ->from('User u')
            ->leftJoin('u.Phonenumber p')
            ->where("u.name = 'jon'")
            ->andWhere("u.loginname = 'jwage'")
            ->orWhere("u.id = 4")
            ->orWhere("u.id = 5")
            ->andWhere("u.name LIKE 'Arnold%'");
            
        $q2 = Doctrine_Query::create()
            ->select('u.id')
            ->from('User u')
            ->leftJoin('u.Phonenumber p')
            ->where("((u.name = 'jon' AND u.loginname = 'jwage') OR (u.id = 4 OR (u.id = 5 AND u.name LIKE 'Arnold%')))");

        $this->assertEqual(
            $q1->getSqlQuery(),
            "SELECT e.id AS e__id FROM entity e LEFT JOIN phonenumber p ON e.id = p.entity_id " .
            "WHERE e.name = 'jon' AND e.loginname = 'jwage' OR e.id = 4 OR e.id = 5 AND e.name LIKE 'Arnold%' AND (e.type = 0)"
        );
        
        $items1 = $q1->execute(array(), Doctrine::HYDRATE_ARRAY);
        $items2 = $q2->execute(array(), Doctrine::HYDRATE_ARRAY);

        $this->assertEqual(count($items1), count($items2));

        $q1->free();
        $q2->free();
    }
}

class MyQuery extends Doctrine_Query
{
    public function preQuery()
    {
        $this->where('u.id = 4');
    }
}