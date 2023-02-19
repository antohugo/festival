//*!Edit 

$(document).ready(function () {

    $('.editbtn').on('click', function () {

        $('#editEmployeeModal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function () {
            return $(this).text().trim();
        }).get();

        console.log(data);
      

        $('#Id_eve').val(data[1]);
        $('#nomEvenement').val(data[2]);
        $('#dateDebutEvt').val(data[3]);
        $('#dateFinEvt').val(data[4]);
        $('#nomGroupe').val(data[5]);
        $('#nomScene').val(data[6]);
        $('#Id_group').val(data[7]);
     
    });
});


//*!Delete

$(document).ready(function () {

    $('.deletebtn').on('click', function () {

        

        $('#deleteEmployeeModal').modal('show');
        console.log($(this).data("id"));

        $('#Id_eve').val($(this).data("id")); 
       
    });
});


     