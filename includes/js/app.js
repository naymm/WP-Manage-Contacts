var ajaxExample = angular.module('ajaxExample', ['ui.bootstrap']);
ajaxExample.filter('startFrom', function () {
    return function (input, start) {
        if (input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});

ajaxExample.controller('mainController', function ($scope, $http, $timeout) {
    $scope.people;

    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
        return function(table, name) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            var blobURL = uri + base64(format(template, ctx))
            return blobURL;
        }
    });
	
    jQuery("#btnExport").click(function () {
		//debugger;
        document.getElementById('ExcelProWarning').style.visibility  = 'visible';
        document.getElementById('ExcelProWarning').style.opacity  = '1';
        setTimeout(function(){document.getElementById('ExcelProWarning').style.opacity  = '0'}, 8000);
    }); 

    jQuery('.wp-contacts-manager-preloader-custom-gif').show();
    jQuery('.wp-contacts-manager-preloader ').show();
    $scope.getPeople = function () {
        $http({
            method: 'GET',
            url: ajaxurl + '?action=WP_Contacts_Manager_call&type=get-results',
        }).then(function (response) {
            $scope.people = response.data;
            $scope.currentPage = 1; //current page
            $scope.filteredItems = $scope.people.length; //Initially for no filter 
            $scope.totalItems = $scope.people.length;
            jQuery('.wp-contacts-manager-preloader-custom-gif').hide();
            jQuery('.wp-contacts-manager-preloader ').hide();
        });
    };

    $scope.addPerson = function () {
        jQuery('.wp-contacts-manager-preloader-custom-gif').show();
        jQuery('.wp-contacts-manager-preloader ').show();
        $http({
            action: 'WP_Contacts_Manager_save',
            method: 'POST',
            url: ajaxurl + '?action=WP_Contacts_Manager_call&type=form-save',
            data: {newName: $scope.newName, newLastname: $scope.newLastname, newPhone: $scope.newPhone, newCompany: $scope.newCompany, newWeb: $scope.newWeb, newJob: $scope.newJob, newEmail: $scope.newEmail, address: $scope.address, newTwo_Address: $scope.newTwo_Address, newTwo_Email: $scope.newTwo_Email, newTwo_Phone: $scope.newTwo_Phone, notes: $scope.notes}
        }).then(function (response) {// on success
            if (response.data.status == true) {
                jQuery('#form_msg').html("<font class='info-green'>" + response.data.success + "</font>");
				$scope.newName = '';
                $scope.newPhone = '';
                $scope.newLastname = '';
                $scope.newEmail = '';
				$scope.newCompany = '';
				$scope.newWeb = '';
				$scope.newJob = '';
                $scope.address = '';
				$scope.newTwo_Email = '';
				$scope.newTwo_Phone = '';
				$scope.newTwo_Address = '';
				$scope.notes = '';
                $scope.getPeople();
                jQuery(".create-contact").hide(700);
            } else {
                jQuery('#form_msg').html("<font class='info-red'>" + response.data.success + "</font>");
            }
            jQuery('.wp-contacts-manager-preloader-custom-gif').hide();
            jQuery('.wp-contacts-manager-preloader ').hide();
            $timeout(function () {
                jQuery('#form_msg').html("");
            }, 2000);

        });
    };

    $scope.editPerson = function (id) {
        jQuery('.wp-contacts-manager-preloader-custom-gif').show();
        jQuery('.wp-contacts-manager-preloader ').show();
		
        var editnewName = angular.element("#editnewName").val();
        var editnewEmail = angular.element("#editnewEmail").val();
        var editnewPhone = angular.element("#editnewPhone").val();
		var editnewCompany = angular.element("#editnewCompany").val();
		var editnewWeb = angular.element("#editnewWeb").val();
		var editnewJob = angular.element("#editnewJob").val();
        var editnewLastname = angular.element("#editnewLastname").val();
        var editcontactID = angular.element("#editcontactID").val();
        var editaddress = angular.element("#editaddress").val();
		var editnewTwo_Address = angular.element("#editnewTwo_Address").val();
		var editnewTwo_Phone = angular.element("#editnewTwo_Phone").val();
		var editnewTwo_Email = angular.element("#editnewTwo_Email").val();
		var editnotes = angular.element("#editnotes").val();

        $http({
            action: 'WP_Contacts_Manager_save',
            method: 'POST',
            url: ajaxurl + '?action=WP_Contacts_Manager_call&type=edit-form-save',
            data: {editnewLastname: editnewLastname, editnewName: editnewName, editnewPhone: editnewPhone, editnewCompany: editnewCompany, editnewWeb: editnewWeb, editnewJob: editnewJob, editnewEmail: editnewEmail, editaddress: editaddress, editnewTwo_Address: editnewTwo_Address,  editnewTwo_Phone: editnewTwo_Phone, editnewTwo_Email: editnewTwo_Email, editnotes: editnotes, editcontactID: editcontactID}
        }).then(function (response) {// on success
            if (response.data.status == true) {
                jQuery('#form_edit_msg').html("<font class='info-green'>" + response.data.success + "</font>");
                jQuery(".edit-contact").hide(700);
                $scope.getPeople();
            } else {
                jQuery('#form_edit_msg').html("<font class='info-red'>" + response.data.success + "</font>");
            }
            jQuery('.wp-contacts-manager-preloader-custom-gif').hide();
            jQuery('.wp-contacts-manager-preloader ').hide();
            $timeout(function () {
                jQuery('#form_edit_msg').html("");
            }, 2000);

        });
    };

    $scope.deletePerson = function (id) {
        $http({
            method: 'POST',
            url: ajaxurl + '?action=WP_Contacts_Manager_call&type=delete',
            data: {recordId: id}
        }).then(function (response) {
            $scope.getPeople();
        }, function (response) {
        });
    };
    $scope.getPeople();


    $scope.deleteConfirm = function (id) {
        jQuery(".delete-confirm").hide();
        jQuery("#delete-confirm" + id).show();
        jQuery("#delete-confirm-yes" + id).click(function () {
            $scope.deletePerson(id);
        });
        jQuery("#delete-confirm-no" + id).click(function () {
            jQuery("#delete-confirm" + id).hide();
        });
    };

    $scope.setPage = function (pageNo) {
        $scope.currentPage = pageNo;
    };
    $scope.filter = function () {
        $timeout(function () {
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
    $scope.sort_by = function (predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };

    $scope.open_contact_form = function () {
        jQuery(".create-contact").show(400);
    };
    $scope.editContact_form = function (id) {
        $http({
            method: 'POST',
            url: ajaxurl + '?action=WP_Contacts_Manager_call&type=get-contact',
            data: {id: id}
        }).then(function (response) {
            angular.element("#editnewName").val(response.data.name);
            angular.element("#editnewEmail").val(response.data.email);
            angular.element("#editnewPhone").val(response.data.phone);
            angular.element("#editnewLastname").val(response.data.lastname);
			angular.element("#editnewCompany").val(response.data.company);
			angular.element("#editnewWeb").val(response.data.web);
			angular.element("#editnewJob").val(response.data.job);
            angular.element("#editcontactID").val(response.data.id);
            angular.element("#editaddress").val(response.data.address);
			angular.element("#editnewTwo_Address").val(response.data.two_address);
			angular.element("#editnewTwo_Email").val(response.data.two_email);
			angular.element("#editnewTwo_Phone").val(response.data.two_phone);
			angular.element("#editnotes").val(response.data.notes);
            jQuery(".edit-contact").show(400);
        });
    };

    $scope.close_contact_form = function () {
        jQuery(".create-contact").hide(400);
        jQuery(".edit-contact").hide(400);
    };

});
