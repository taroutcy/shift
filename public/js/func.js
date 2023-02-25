function manageDispSelect(work_status_id, num) {
    let select = document.getElementById('shift' + num);
    
    if (work_status_id == '1') {
        select.disabled = false;
    } else {
        select.disabled = true;
    }
};
