function courseDropdown(){
    var coursesDiv = document.getElementById("courses");
    var arrow = document.getElementById("arrow");
    var course = document.getElementById("course_dd")
    coursesDiv.classList.toggle("hidden");

    if (!coursesDiv.classList.contains("hidden")) {
        arrow.style.fill = "#833ae0";
        course.classList.add('text-[#833ae0]')
    } else {
        arrow.style.fill = "black";
        course.classList.remove('text-[#833ae0]')
    }
}

function studentsDropdown(){
    var studentsDiv = document.getElementById("students");
    studentsDiv.classList.toggle("hidden");
    var arrow = document.getElementById("arrow1");
    var course = document.getElementById("students_dd")

    if (!studentsDiv.classList.contains("hidden")) {
        arrow.style.fill = "#833ae0";
        course.classList.add('text-[#833ae0]')
    } else {
        arrow.style.fill = "black";
        course.classList.remove('text-[#833ae0]')
    }
}

function scheduleDropdown(){
    var schedulesDiv = document.getElementById("schedules");
    schedulesDiv.classList.toggle("hidden");
}

function officeDropdown(){
    var officeDiv = document.getElementById("office");
    officeDiv.classList.toggle("hidden");
}

function showAddForm(){
    var add_form = document.getElementById('add_form');
    var body = document.getElementById('body');
    add_form.classList.toggle('hidden')
    
    if(!add_form.classList.contains('hidden')){
        body.style.filter = 'blur(2px)'
    } else {
        body.style.filter = 'blur(0px)'
    }
}

function showAddClient(){
    var add_form = document.getElementById('add_schedule');
    var body = document.getElementById('body');
    add_form.classList.toggle('hidden')
    
    if(!add_form.classList.contains('hidden')){
        body.style.filter = 'blur(2px)'
    } else {
        body.style.filter = 'blur(0px)'
    }
}

function closeAddForm(){
    var add_form = document.getElementById('add_schedule');
    var body = document.getElementById('body');
    add_form.classList.add('hidden')
    body.style.filter = 'blur(0px)'
}

function closeUpdateForm(){
    var update_form = document.getElementById('edit_schedule');
    var body = document.getElementById('body');
    update_form.classList.add('hidden')
    body.style.filter = 'blur(0px)'
}

function editSchedule(data) {
    var add_form = document.getElementById('edit_schedule');
    var body = document.getElementById('body');
    add_form.classList.toggle('hidden')
    
    if(!add_form.classList.contains('hidden')){
        body.style.filter = 'blur(2px)'
    } else {
        body.style.filter = 'blur(0px)'
    }

    const rowData = JSON.parse(data);
    const editScheduleDiv = document.getElementById('edit_schedule');
    
    // Update the content of the edit_schedule div with rowData
    // For example, you can update input fields with rowData values
    editScheduleDiv.querySelector('input[name="parents_name"]').value = rowData.parents_name;
    editScheduleDiv.querySelector('input[name="childs_name"]').value = rowData.childs_name;
    editScheduleDiv.querySelector('input[name="age"]').value = rowData.age;
    editScheduleDiv.querySelector('input[name="contact_number"]').value = rowData.contact_number;
    editScheduleDiv.querySelector('input[name="email_address"]').value = rowData.email_address;
    
    // Show the edit_schedule div
    editScheduleDiv.classList.remove('hidden');
}

function proceed(data){
    var proceed = document.getElementById('proceed')
    var body = document.getElementById('body');
    proceed.classList.remove('hidden')

    if(!proceed.classList.contains('hidden')){
        body.style.filter = 'blur(2px)'
    } else {
        body.style.filter = 'blur(0px)'
    }

    const rowData = JSON.parse(data);
    const proceedDiv = document.getElementById('proceed');
    
    proceedDiv.querySelector('input[name="student_name"]').value = rowData.childs_name;
    proceedDiv.querySelector('input[name="parent_name"]').value = rowData.parents_name;
    proceedDiv.querySelector('input[name="age"]').value = rowData.age;
    proceedDiv.querySelector('input[name="contact_number"]').value = rowData.contact_number;
    proceedDiv.querySelector('input[name="email_address"]').value = rowData.email_address;
}
function closeProceedForm(){
    var proceeed_form = document.getElementById('proceed');
    var body = document.getElementById('body');
    proceeed_form.classList.add('hidden')
    body.style.filter = 'blur(0px)'
}

function showAddIlSched(){
    var add_form = document.getElementById('il_sched');
    var body = document.getElementById('body');
    add_form.classList.toggle('hidden')
    
    if(!add_form.classList.contains('hidden')){
        body.style.filter = 'blur(2px)'
    } else {
        body.style.filter = 'blur(0px)'
    }

}

function proceedToEnrollment(data){
    var proceed = document.getElementById('proceed');
    var body = document.getElementById('body');
    proceed.classList.toggle('hidden')

    if(!proceed.classList.contains('hidden')){
        body.style.filter = 'blur(2px)'
    } else {
        body.style.filter = 'blur(0px)' 
    }

    const rowData = JSON.parse(data);
    const proceedDiv = document.getElementById('proceed');
    
    proceedDiv.querySelector('input[name="student_name"]').value = rowData.student_name;
}