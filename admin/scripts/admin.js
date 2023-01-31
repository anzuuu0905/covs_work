$(document).ready(function() {
  $('#delete, .delete').submit(function(){
    if (confirm('本当に削除してもよろしいですか？')) {
      return true;
    } else {
      return false;
    }
  });

  $('.autosubmit').change(function(){
    $(this).parents('form').eq(0).submit();
  });
});