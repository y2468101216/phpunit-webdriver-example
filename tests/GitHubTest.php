<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use Facebook\WebDriver\WebDriverExpectedCondition;

class GitHubTests extends PHPUnit_Framework_TestCase{
	protected $webDriver;
	protected $url = 'https://github.com';
	
	//create webdriver intenface
	public function setUp(){
		$host = 'http://localhost:4444/wd/hub'; // this is the default
		$caps = DesiredCapabilities::firefox();
		$this->webDriver = RemoteWebDriver::create($host, $caps);
	}
	
	//close webdriver intenface
	 public function tearDown()
    {
        $this->webDriver->quit();
    }
	
	public function testGitHubHome()
    {
        $this->webDriver->get($this->url);
        $this->assertContains('GitHub', $this->webDriver->getTitle());
    }
	
	public function testSearch()
    {
        $this->webDriver->get($this->url);
        
        $search = $this->webDriver->findElement(WebDriverBy::name('q'));
        $search->click();
		$this->webDriver->getKeyboard()->sendKeys('php-webdriver');
        $this->webDriver->getKeyboard()->sendKeys(WebDriverKeys::ENTER);
        $this->webDriver->wait(20, 1000)->until(WebDriverExpectedCondition::titleContains('Search'));
        
        $element = $this->webDriver->findElement(WebDriverBy::tagName('em'));
        $this->webDriver->takeScreenshot('screenshots/testSearch.png');
        $this->assertContains('php-webdriver', $element->getText());
        
    }        
}