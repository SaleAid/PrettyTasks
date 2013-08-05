 <?php
App::uses('TagList', 'Model');
App::uses('CakeEventListener', 'Event'); 
class TagEventListener implements CakeEventListener {
 
  public function implementedEvents() {
    return array(
      'Model.Tag.addToList' => 'eventAddTolist',
    );
  }
 
  public function eventAddTolist($event){
    extract($event->data);
    $TagList = new TagList($userId, $tagId, $model);
    if($TagList->isInList($foreignKey) === false){
        $TagList->addToList($foreignKey);    
    }
  }
  
}