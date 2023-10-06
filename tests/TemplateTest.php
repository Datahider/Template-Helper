<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace losthost\templateHelper;
use PHPUnit\Framework\TestCase;
/**
 * Description of TemplateTest
 *
 * @author drweb
 */
class TemplateTest extends TestCase {
    
    public function testExceptionIfNoTemplatesDir() {
        
        $this->expectExceptionCode(-10007);
        $template = new Template('test.tpl');
        $template->display();
        
    }
    
    public function testPrepareTestTemplate() {
        mkdir('tpl');
        mkdir('tpl/default');
        file_put_contents('tpl/default/test.tpl', <<<END
                Hello <?=\$name; ?>!
                END);
        
        mkdir('tpl/tr');
        file_put_contents('tpl/tr/test.tpl', <<<END
                Privet <?=\$name; ?>!
                END);

        $this->assertTrue(file_exists('tpl/default/test.tpl'));
        $this->assertTrue(file_exists('tpl/tr/test.tpl'));
    }
    
    public function testPropperDisplay() {
        $template = new Template('test.tpl');
        $template->setTemplateDir('tpl');
        $template->assign('name', "John");
        
        ob_start();
        $template->display();
        $result = ob_get_clean();
        
        $this->assertSame("Hello John!", $result);
    }
    
    public function testPropperProcess() {
        $template = new Template('test.tpl');
        $template->setTemplateDir('tpl');

        $template->assign('name', "John");
        $this->assertSame("Hello John!", $template->process());
    }
    
    public function testPropperProcessUnknownLanguage() {
        $template = new Template('test.tpl', 'jp');
        $template->setTemplateDir('tpl');
        
        $template->assign('name', 'John');
        $this->assertSame('Hello John!', $template->process());
    }
    
    public function testPropperProcessingPropperLanguage() {
        $template = new Template('test.tpl', 'tr');
        $template->setTemplateDir('tpl');
        
        $template->assign('name', 'John');
        $this->assertSame('Privet John!', $template->process());
    }
    
    public function testCleanup() {
        unlink('tpl/default/test.tpl');
        unlink('tpl/tr/test.tpl');
        rmdir('tpl/default');
        rmdir('tpl/tr');
        rmdir('tpl');
        
        $this->assertFalse(file_exists('tpl'));
    }
}
