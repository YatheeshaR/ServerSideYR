<footer>
        <hr/>
        &copy;stack Overflow 2019-20
    </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.js"></script>
    <script>
      $('#summernote').summernote({
        placeholder: 'Enter Question here...',
        tabsize: 2,
        height: 300
      });
      $(".btn-danger").click(function(){
        var tag = $(this).html();
        var tag_input = $("#tag").val().trim();

        if(tag_input.length==0){
          $("#tag").val(tag);
        }else if(tag_input.search(tag)==-1){
          $("#tag").val(tag_input+", "+tag);
        }else if(tag_input.search(tag)>-1){
            if(tag_input.search(",")>-1){
              var tag_array = tag_input.split(", ");
              var pos = jQuery.inArray(tag, tag_array);
              if(pos) {
                tag_array.splice(pos,1);
                $("#tag").val(tag_array.toString());

              } else {
                $("#tag").val(tag_input+", "+tag);
              }
            }else{
              $("#tag").val("");
            }
        }
        return false;
      });
    </script>
</body>
</html>
