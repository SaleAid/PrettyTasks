<div class="faqs index">
    <h2><?php __('F.A.Q.');?></h2>  
    <div  id="itemsbox">
        <a id="top"></a>   
        <ul id="questions"><?php
                foreach ($faqcategories as $faqcategory):
                    //debug($faqcategory); 
                ?>
                <li><?php echo "<a href='#c".($faqcategory['Faqcategory']['id'])."'>".$faqcategory['Faqcategory']['name']."</a>"?>            
                    <ul><?php
                            foreach ($faqcategory['Faq'] as $faq):
                            ?>
                            <li>						
                                <?php echo "<a href='#q".($faq['id'])."'>".($faq['id']).". ".($faq['subject'])."</a>"; ?>
                            </li><?php endforeach; ?>
                    </ul></li> 
                <?php endforeach; ?>
        </ul>
        <div id="answers"><?php
                foreach ($faqcategories as $faqcategory):
                    //debug($faqcategory);
                ?>

                <?php  echo "<div id='c".($faqcategory['Faqcategory']['id'])."'>".$faqcategory['Faqcategory']['name'];?>  
                <?php
                    foreach ($faqcategory['Faq'] as $faq):
                    ?>
                    <div>
                        <div class="qbox_topbtn"><a href="#top">Go up</a></div>
                        <div class="qbox_faqs"><span>Q:</span>    
                            <?php echo "<a id='q".($faq['id'])."'></a>"?>    
                            <?php echo $faq['id']; ?>
                            <?php echo $faq['subject']; ?>
                        </div>

                        <div class="qbox_content"><span>A:</span>
                        <?php echo $faq['content']; ?>
                    </div>
                </div>
                <?php endforeach; ?>
        </div> 
        <?php endforeach; ?>
            </div>
    </div>
    </div> 