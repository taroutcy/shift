function manageDispSelect(work_status_id, date) {
    let select = document.getElementById('shift' + date);
    
    if (work_status_id == '1') {
        select.disabled = false;
    } else {
        select.disabled = true;
    }
};

function inShiftSlect(id) {
    let select = document.getElementById('shift' + id);
    
    if (select.value) {
       return true;
    } else {
        return false;
    }
};