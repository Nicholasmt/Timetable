function load_timetable(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let semester = $('#semester').val();
    let venue = $('#venue').val();
    
     $.get(base_url+"/monitoring/load-timetable",{semester:semester, venue:venue}, function (data,status,error) {
      if (data) {
        // console.log(data)
        $("#load_timetable").html(data);
        } else {
        $("#load_timetable").html(error);
        }
      });
 
    ev.preventDefault();
}

function loadReportData(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let value = $(this).attr("value");
     $.get(base_url+"/monitoring/Report-data/"+ value, {}, function (data,status,error) {
      if (data) {
        $("#records").html(data);
        } else {
        $("#records").html(error);
        }
      });

}

$("body").on("click", "#loadBtn", load_timetable);
$("body").on("click", "#loadReport", loadReportData);