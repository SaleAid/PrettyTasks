<?php
/**
 * SEO Component
 * it's used very simply: in controller write
 * $this->Seo->title = 'Some title';// for title
 * $this->Seo->description = 'Some description';// for description
 * $this->Seo->keywords = 'Some keywords';// for keywords
 *
 */
App::uses('Component', 'Controller');

class SeoComponent extends Component {

 /**
  * Current controller
  *
  * @var AppController
  */
 private $controller;

    /**
    * @desc Seo info
    * @var array
    */
    private $params = array();

    /**
     * @desc Allowed meta params
     * @var array
     */
    private $allowed_params = array('title', 'description', 'keywords');

    /**
     * @desc Binding other cake components
     * @var array
     */
    public $components = array('Core');

    /**
    * @desc Core component - variable used for intellicence
    * @var CoreComponent
    * @access public
    */
    public $Core;

    /**
     * Constructor.
     *
     */
    public function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection, $settings);
        foreach($this->allowed_params as $allowed_param){
            $this->{$allowed_param} = '';
        }
    }

    /**
    * @desc Startup method. Don't forget call it!
    * @param AppController $controller
    * @access public
    * @return void
    */
    public function startup(Controller $controller) {
      $this->controller = $controller;
            foreach($this->allowed_params as $key)
                $controller->set($key . '_for_layout', $this->{$key});
    
     }

    /**
     *
     * @param object $controller A reference to the controller
     * @param array $settings Array of settings to _set().
     * @return void
     * @access public
     */
    public function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    /**
     * @desc standard class getter
     */
    public function __get($key){
        return array_key_exists($key, $this->params) ? $this->params[$key] : null;
    }

    /**
     * @desc standard class setter
     */
    public function __set($key, $value){
        if (in_array($key, $this->allowed_params)) {
            $this->params[$key] = $value;
            $this->setView($key);
            //debug($key);
        }
    }

 /**
  * @desc Set Meta info for view
  *
  * @param string $pageTitle Title
  */
    protected function setView($key = null) {
        if (!$this->controller)return;
        $this->controller->set($key . '_for_layout', $this->{$key});
    }

    /**
     * @desc Auto fill meta info from pages table
     * @return boolean - success of oparation
     * @access public
     */
    public function autoFill(){
        $page = $this->Core->getCurrentPage();
        if ($page){
            foreach($this->allowed_params as $key){
                $this->{$key} = $page['Page'][$key];
            }
            return true;
        }
        return false;
    }

    /**
     * Called after the Controller::beforeRender(), after the view class is loaded, and before the
     * Controller::render()
     *
     * @param object $controller Controller with components to beforeRender
     * @return void
     * @access public
     * @deprecated See Component::triggerCallback()
     */
    public function beforeRender(Controller $controller) {
        foreach($this->allowed_params as $key)
            $controller->set($key . '_for_layout', $this->{$key});
    }

}