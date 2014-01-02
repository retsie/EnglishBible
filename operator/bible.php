<?php
class Bible {
  
      public function getChapter($book_id){
          $query = mysql_query("select distinct chapter_number from kjv_english where 
                              book_id = {$book_id} ");
          echo " <hr><b>CHAPTER</b><br>";
          if(mysql_num_rows($query)>0){
               while($row= mysql_fetch_array($query)){
               $action = "loadVerse(".$row['chapter_number'].", \"".
                                      $row['chapter_number']."\")";
               $this->tiler($row['chapter_number'], $action);  
               }
          }
     }

      public function getVerse($book_id, $chapter){
          $query = mysql_query("select distinct verse_number from kjv_english where 
                              book_id = {$book_id} and 
                              chapter_number = {$chapter}");
          echo " <hr><b>VERSE</b><br>";
          if(mysql_num_rows($query)>0){
               while($row= mysql_fetch_array($query)){
               $action = "loadBible(".$row['verse_number'].")";
               $this->tiler($row['verse_number'], $action);   
               }
          }
     }

     public function getBookList(){
     $query = mysql_query("select * from bookList where BookTestament = 'Old'");
          echo "<hr><b>OLD TESTAMENT</b><br><br>";
          if(mysql_num_rows($query)>0){
               while($row= mysql_fetch_array($query)){
               $action = "loadChapter(".$row['bookList_id'].", \"".
                                        $row['BookName']."\")";
               $this->tiler($row['BookCode'], $action);  
               }
          }
          echo "<br><br><hr><b>NEW TESTAMENT</b><br><br>";
          $query1 = mysql_query("select * from bookList where BookTestament = 'New'");
          if(mysql_num_rows($query)>0){
               while($row= mysql_fetch_array($query1)){
               $action = "loadChapter(".$row['bookList_id'].", \"".
                                        $row['BookName']."\")";
               $this->tiler($row['BookCode'], $action);
               }
          }
     }

     public function getBible($book_id, $chapter, $verse){
          $query = mysql_query("select verse_text from kjv_english where 
                              book_id = {$book_id} and 
                              chapter_number = {$chapter} and 
                              verse_number = {$verse}");
          if(mysql_num_rows($query)>0){
               $row= mysql_fetch_array($query);
               echo "<div id = 'verseText'>".$row['verse_text']."</div>";
          }
     }

     public function getBack($bookid, $chapterid, $verseid){
          $book_id = $bookid;
          $chapter = $chapterid;
          $verse = $verseid - 1;
          $query = mysql_query("select * from kjv_english k JOIN bookList 
                    b ON(k.book_id = b.bookList_id ) where 
                              book_id = {$book_id} and 
                              chapter_number = {$chapter} and 
                              verse_number = {$verse}");
          if(mysql_num_rows($query)>0){
               $row= mysql_fetch_array($query);
               $phrase = $row['verse_text'];
               $bookname = $row['BookName'];
               $json = "{
                    \"bookname\" : \"".$bookname."\",
                    \"book\" : ".$book_id.",
                    \"chapter\" : ".$chapter.",
                    \"verse\" : ".$verse.",
                    \"phrase\" : \"".$phrase."\"
               }";
               echo $json;
          }else{
               $chapter = $chapter - 1;
               $verse = $this->getMaxVerse($book_id, $chapter);
               $sql = "select * from kjv_english k JOIN bookList
                         b ON(k.book_id = b.bookList_id ) where 
                              book_id = {$book_id} and 
                              chapter_number = {$chapter} and 
                              verse_number = {$verse}";
               $query = mysql_query($sql);
               if(mysql_num_rows($query)>0){
                    $row= mysql_fetch_array($query);
                    $phrase = $row['verse_text'];
                    $bookname = $row['BookName'];
                    $json = "{
                         \"bookname\" : \"".$bookname."\",
                         \"book\" : ".$book_id.",
                         \"chapter\" : ".$chapter.",
                         \"verse\" : ".$verse.",
                         \"phrase\" : \"".$phrase."\"
                    }";
                    echo $json;
               }else{
                    $book_id = $book_id - 1;
                    $chapter = $this->getMaxChapter($book_id); 
                    $verse = $this->getMaxVerse($book_id, $chapter);
                    $query = mysql_query("select * from kjv_english k JOIN bookList 
                              b ON(k.book_id = b.bookList_id ) where 
                                   book_id = {$book_id} and 
                                   chapter_number = {$chapter} and 
                                   verse_number = {$verse}");
                    if(mysql_num_rows($query)>0){
                         $row= mysql_fetch_array($query);
                         $phrase = $row['verse_text'];
                         $bookname = $row['BookName'];
                         $json = "{
                              \"bookname\" : \"".$bookname."\",
                              \"book\" : ".$book_id.",
                              \"chapter\" : ".$chapter.",
                              \"verse\" : ".$verse.",
                              \"phrase\" : \"".$phrase."\"
                         }";
                         echo $json;
                    }else{
                          $query = mysql_query("select * from kjv_english k JOIN bookList 
                                   b ON(k.book_id = b.bookList_id ) where 
                                         book_id = 66 and 
                                         chapter_number = 22 and 
                                         verse_number = 21");
                         if(mysql_num_rows($query)>0){
                              $row= mysql_fetch_array($query);
                              $phrase = $row['verse_text'];
                              $bookname = $row['BookName'];
                              $json = "{
                                   \"bookname\" : \"".$bookname."\",
                                   \"book\" : 66,
                                   \"chapter\" : 22,
                                   \"verse\" : 21,
                                   \"phrase\" : \"".$phrase."\"
                              }";
                              echo $json;
                         }
                    }
               }
          }
     }
     
     public function getMaxVerse($book_id, $chapter){
          if($chapter > 0){
               $query = mysql_query("select max(verse_number) as verse from kjv_english where
                                   book_id = {$book_id} AND 
                                   chapter_number = {$chapter}");
               if(mysql_num_rows($query)>0){
                    $row= mysql_fetch_array($query);
                    return $row['verse'];
               }
          }else{
               return 0;
          }
     }
     public function getMaxChapter($book_id){
           if($book_id > 0){
               $query = mysql_query("select max(chapter_number) as chapter from kjv_english where   
                                   book_id = {$book_id}");
               if(mysql_num_rows($query)>0){
                    $row= mysql_fetch_array($query);
                    return $row['chapter'];
               }
          }else{
               return 0;
          }
     }

     public function getForward($bookid, $chapterid, $verseid){
          $book_id = $bookid;
          $chapter = $chapterid;
          $verse = $verseid + 1;
          $query = mysql_query("select * from kjv_english k JOIN bookList 
                    b ON(k.book_id = b.bookList_id ) where 
                              book_id = {$book_id} and 
                              chapter_number = {$chapter} and 
                              verse_number = {$verse}");
          if(mysql_num_rows($query)>0){
               $row= mysql_fetch_array($query);
               $phrase = $row['verse_text'];
               $bookname = $row['BookName'];
               $json = "{
                    \"bookname\" : \"".$bookname."\",
                    \"book\" : ".$book_id.",
                    \"chapter\" : ".$chapter.",
                    \"verse\" : ".$verse.",
                    \"phrase\" : \"".$phrase."\"
               }";
               echo $json;
          }else{
               $verse = 1;
               $chapter = $chapter + 1;
               $query = mysql_query("select * from kjv_english k JOIN bookList 
                         b ON(k.book_id = b.bookList_id ) where 
                                   book_id = {$book_id} and 
                                   chapter_number = {$chapter} and 
                                   verse_number = {$verse}");
               if(mysql_num_rows($query)>0){
                    $row= mysql_fetch_array($query);
                    $phrase = $row['verse_text'];
                    $bookname = $row['BookName'];
                    $json = "{
                         \"bookname\" : \"".$bookname."\",
                         \"book\" : ".$book_id.",
                         \"chapter\" : ".$chapter.",
                         \"verse\" : ".$verse.",
                         \"phrase\" : \"".$phrase."\"
                    }";
                    echo $json;
               }else{
                    $verse = 1;
                    $chapter = 1;
                    $book_id = $book_id + 1;
               
                    $query = mysql_query("select * from kjv_english k JOIN bookList 
                              b ON(k.book_id = b.bookList_id ) where 
                                        book_id = {$book_id} and 
                                        chapter_number = {$chapter} and 
                                        verse_number = {$verse}");
                    if(mysql_num_rows($query)>0){
                         $row= mysql_fetch_array($query);
                         $phrase = $row['verse_text'];
                         $bookname = $row['BookName'];
                         $json = "{
                              \"bookname\" : \"".$bookname."\",
                              \"book\" : ".$book_id.",
                              \"chapter\" : ".$chapter.",
                              \"verse\" : ".$verse.",
                              \"phrase\" : \"".$phrase."\"
                         }";
                         echo $json;
                    }else{
                          $query = mysql_query("select * from kjv_english k JOIN bookList 
                                   b ON(k.book_id = b.bookList_id ) where 
                                              book_id = 1 and 
                                              chapter_number = 1 and 
                                              verse_number = 1");
                         if(mysql_num_rows($query)>0){
                              $row= mysql_fetch_array($query);
                              $phrase = $row['verse_text'];
                              $bookname = $row['BookName'];
                              $json = "{
                                   \"bookname\" : \"".$bookname."\",
                                   \"book\" : ".$book_id.",
                                   \"chapter\" : ".$chapter.",
                                   \"verse\" : ".$verse.",
                                   \"phrase\" : \"".$phrase."\"
                              }";
                              echo $json;
                         }
                    }
               }
          }
     }

     public function getSearch($search, $testament){
           $era = "";
           if ($testament != "all"){
               $era = "and BookTestament = '{$testament}'";
           }
          $query = mysql_query("select * from kjv_english k JOIN bookList 
                    b ON(k.book_id = b.bookList_id ) where 
                              verse_text LIKE '%{$search}%' {$era} order by k.book_id asc");
          $num_rows = mysql_num_rows($query);
          if($num_rows>0){
               echo "<div>".$num_rows." results found</div><hr>";
               while($row= mysql_fetch_array($query)){
                    $sResult = substr($row['verse_text'], 0, 30);
                    echo "<div onclick = \"loadPhrase('".$row['BookName']."',
                               ".$row['book_id'].",
                               ".$row['chapter_number'].",
                               ".$row['verse_number'].")\">";
                    echo $row['BookName']." ".
                         $row['chapter_number'].":".
                         $row['verse_number']."<br>";
                  echo $sResult."...</div><hr>";       
               }
          }else{
           echo "no result found";
          }
     }

    public static function get_verse($id) {   
       $query = mysql_query("select verse_text from kjv_english where book_id = '{$id}'");
    }	

    public function tiler($value, $action){
          $tile = "<div class = 'tile' onclick = '".$action."'>".$value."</div>";
          echo $tile;
    }			
   
}
?>
