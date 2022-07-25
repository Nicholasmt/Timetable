function unblock_allocation(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let caid=$(this).attr('data-caid');
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_url + "/admin/allocation/unblock",
        method: "POST",
        data: {caid:caid},
        beforeSend: function () {
            if (confirm("Confirm that you want to unblock the course allocation ?"))
            return true;
            else return false;
        },
        success: function (data, status, error) {
          if(data.status==true)
          {
              alert(data.message);
              location.reload();
          }
          else{
            alert(data.message);
            location.reload();
          }
        },
        error:function(error)
        {
           console.log("Error Message "+error);
           alert('Error Message :'+error);

        }
    });
    ev.preventDefault();
}

$("body").on("click", "#unblock_allocation", unblock_allocation);
