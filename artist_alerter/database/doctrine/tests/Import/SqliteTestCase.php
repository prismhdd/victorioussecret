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
 * Doctrine_Import_Sqlite_TestCase
 *
 * @package     Doctrine
 * @author      Konsta Vesterinen <kvesteri@cc.hut.fi>
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @category    Object Relational Mapping
 * @link        www.phpdoctrine.org
 * @since       1.0
 * @version     $Revision$
 */
class Doctrine_Import_Sqlite_TestCase extends Doctrine_UnitTestCase 
{
    public function testListSequencesExecutesSql() 
    {
        $this->import->listSequences('table');
        
        $this->assertEqual($this->adapter->pop(), "SELECT name FROM sqlite_master WHERE type='table' AND sql NOT NULL ORDER BY name");
    }
    public function testListTableColumnsExecutesSql()
    {
        $this->import->listTableColumns('table');
        
        $this->assertEqual($this->adapter->pop(), "PRAGMA table_info(table)");
    }
    public function testListTableIndexesExecutesSql()
    {
        $this->import->listTableIndexes('table');
        
        $this->assertEqual($this->adapter->pop(), "PRAGMA index_list(table)");
    }
    public function testListTablesExecutesSql()
    {
        $this->import->listTables();
        
        $q = "SELECT name FROM sqlite_master WHERE type = 'table' UNION ALL SELECT name FROM sqlite_temp_master WHERE type = 'table' ORDER BY name";

        $this->assertEqual($this->adapter->pop(), $q);
    }
}
