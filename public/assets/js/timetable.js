function set_timetable(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let semester=$(this).attr('value');
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_url + "/timetable/set",
        method: "POST",
        data: {semester:semester},
        beforeSend: function () {
            if (confirm("Confirm that you want to set the timetable ?"))
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

function submit_allocation(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let semester=$(this).attr('data-sem');
    let department=$(this).attr('data-dept');
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: base_url + "/departmentalOfficer/allocation/submit",
        method: "POST",
        data: {semester:semester,department:department},
        beforeSend: function () {
            if (confirm("Confirm that you want to submit the course allocation ?"))
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

$("body").on("click", "#set_timetable", set_timetable);
$("body").on("click", "#submit_allocation", submit_allocation);
