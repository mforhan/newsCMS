 <div class="summary">
  <fieldset>
   <legend>Management</legend>

   <fieldset class="toggle01"> <!-- Story Short -->
    <legend>Active Stories</legend>
    <ul style="list-style:none;padding:0;">

<?
 while($story = $res->fetch(PDO::FETCH_OBJ)) {
   $article  = $story->article_id;
   $headline = $story->headline;
   $hasPhoto = $story->hasPhoto;
   
?>
<!-- Story One --> 
     <li style="clear:both;">
      <div class="item">
       <div class="desc"><a href="edit.php?article_id=<?= $article_id; ?>"><?= $headline; ?></a></div>
       <div class="price"><input type="checkbox" /></div>
       <!--<div class="descriptor">Qty (1)</div>-->
      </div>
     </li>
<!-- End Story One --> 
<? } ?>
    </ul>
  </fieldset>

  <input type="submit" value="Send to Editor" style="float:right;"/>

  <fieldset class="toggle01" style="clear:both;"> 
   <legend>Completed Stories</legend>
   <ul style="list-style:none;padding:0;">

<!-- Story One --> 
     <li style="clear:both;">
      <div class="item">
       <div class="desc"><a href="edit.php?article_id=1126">Crunch Pak, the heart of a growing industry</a></div>
      </div>
     </li>
<!-- End Story One --> 
    </ul>
  </fieldset>
 </fieldset>
</div>
<!-- <fieldset>
 <legend>Active Stories</legend>
 <ul style="list-style:none;padding:0;">
  <li><a href="edit.php?article_id=1138">Crunch Pak, the heart of a growing industry</a><input type="checkbox" /></li>
  <li><a href="edit.php?article_id=1138">Crunch Pak, the heart of a growing industry</a><input type="checkbox" /></li>
 </ul>
</fieldset> -->
