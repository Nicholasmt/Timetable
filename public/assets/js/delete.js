function delete_department(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let value = $(this).attr("value");
     $.get(base_url+"/admin/confirm-department-delete/"+ value, {}, function (data,status,error) {
      if (data) {
        $("#confrim-modal").html(data);
        } else {
        $("#confrim-modal").html(error);
        }
      });

}

function delete_user(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let value = $(this).attr("value");
     $.get(base_url+"/admin/confirm-user-delete/"+ value, {}, function (data,status,error) {
      if (data) {
        $("#confrim-modal").html(data);
        } else {
        $("#confrim-modal").html(error);
        }
      });

}

function delete_semester(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let value = $(this).attr("value");
     $.get(base_url+"/admin/confirm-semester-delete/"+ value, {}, function (data,status,error) {
      if (data) {
        $("#confrim-modal").html(data);
        } else {
        $("#confrim-modal").html(error);
        }
      });

}

function delete_course(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let value = $(this).attr("value");
     $.get(base_url+"/admin/confirm-course-delete/"+ value, {}, function (data,status,error) {
      if (data) {
        $("#confirm-modal").html(data);
        } else {
        $("#confirm-modal").html(error);
        }
      });

}

function delete_venue(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let value = $(this).attr("value");
     $.get(base_url+"/admin/confirm-venue-delete/"+ value, {}, function (data,status,error) {
      if (data) {
        $("#confirm-modal").html(data);
        } else {
        $("#confirm-modal").html(error);
        }
      });

}

function delete_lecturer(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let value = $(this).attr("value");
     $.get(base_url+"/admin/confirm-lecturer-delete/"+ value, {}, function (data,status,error) {
      if (data) {
        $("#confirm-modal").html(data);
        } else {
        $("#confirm-modal").html(error);
        }
      });

}
function delete_courseAllocation(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let value = $(this).attr("value");
     $.get(base_url+"/departmentalOfficer/confirm-courseAllocation-delete/"+ value, {}, function (data,status,error) {
      if (data) {
        $("#confirm-modal").html(data);
        } else {
        $("#confirm-modal").html(error);
        }
      });
    
}
 
  
function adminTimetable_delete(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let semester = $('#semester').val();
    let timetable = $('#timetable').val();
      $.get(base_url+"/admin/delete-timetable/",{semester:semester, timetable:timetable}, function (data,status,error) {
      if (data) {
        
        $("#confirm-modal").html(data);
        } else {
        $("#confirm-modal").html(error);
        }
      });
 
    ev.preventDefault();
}

function departmentalOfficerTimetable_delete(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let semester = $('#semester').val();
    let timetable = $('#timetable').val();
      $.get(base_url+"/departmentalOfficer/delete-timetable/",{semester:semester, timetable:timetable}, function (data,status,error) {
      if (data) {
       
        $("#confirm-modal").html(data);
        } else {
        $("#confirm-modal").html(error);
        }
      });
 
    ev.preventDefault();
}
    
function timetableOfficerTimetable_delete(ev)
{
    let base_url = $('meta[name="site_url"]').attr("content");
    let semester = $('#semester').val();
    let timetable = $('#timetable').val();
      $.get(base_url+"/timetableAdmin/delete-timetable/",{semester:semester, timetable:timetable}, function (data,status,error) {
      if (data) {
        
        $("#confirm-modal").html(data);
        } else {
        $("#confirm-modal").html(error);
        }
      });
 
    ev.preventDefault();
}
    


 

 
$("body").on("click", "#delete", delete_department);
$("body").on("click", "#delete-user", delete_user);
$("body").on("click", "#delete-semester", delete_semester);
$("body").on("click", "#delete-course", delete_course);
$("body").on("click", "#delete-venue", delete_venue);
$("body").on("click", "#delete-lecturer", delete_lecturer);
$("body").on("click", "#delete-courseAllocation", delete_courseAllocation);
$("body").on("click", "#delete-timetable", adminTimetable_delete);
$("body").on("click", "#delete-timetable_3", departmentalOfficerTimetable_delete);
$("body").on("click", "#delete-timetable_2", timetableOfficerTimetable_delete);
 
 
