function reset() {
	if (document.getElementById("formadd")) {
		document.getElementById("formadd").reset();
		var formadd = $("#formadd").validate();
		formadd.resetForm();
	}
	if (document.getElementById("formadd2")) {
		document.getElementById("formadd2").reset();
		var formadd2 = $("#formadd2").validate();
		formadd2.resetForm();
	}
	if (document.getElementById("formedit")) {
		document.getElementById("formedit").reset();
		var formedit = $("#formedit").validate();
		formedit.resetForm(); 
	}
	if (document.getElementById("formall")) {
		document.getElementById("formall").reset();
		var formall = $("#formall").validate();
		formall.resetForm(); 
	}
	if (document.getElementById("formall1")) {
		document.getElementById("formall1").reset();
		var formall1 = $("#formall1").validate();
		formall1.resetForm(); 
	}
	if (document.getElementById("formall2")) {
		document.getElementById("formall2").reset();
		var formall2 = $("#formall2").validate();
		formall2.resetForm(); 
	}
	if (document.getElementById("formall3")) {
		document.getElementById("formall3").reset();
		var formall3 = $("#formall3").validate();
		formall3.resetForm(); 
	}
	if (document.getElementById("formall4")) {
		document.getElementById("formall4").reset();
		var formall4 = $("#formall4").validate();
		formall4.resetForm(); 
	}
	if (document.getElementById("formall5")) {
		document.getElementById("formall5").reset();
		var formall5 = $("#formall5").validate();
		formall5.resetForm(); 
	}
	if (document.getElementById("formitem")) {
		document.getElementById("formitem").reset();
		var formitem = $("#formitem").validate();
		formitem.resetForm(); 
	}
	if (document.getElementById("formitem2")) {
		document.getElementById("formitem2").reset();
		var formitem2 = $("#formitem2").validate();
		formitem2.resetForm(); 
	}
	$(".has-error").removeClass("has-error");
}

//DATA TABLES SERVER SIDE
function FormatResult(data) {
	markup = '<div>'+data.text+'</div>';
	return markup;
}

function FormatSelection(data) {
	return data.text;
}
//END DATA TABLES SERVER SIDE

//ALERT FUNCTION
function alert_success_save() {
	swal({
		title: "Success!",
		text: "Data telah tersimpan!",
		type: "success",
		confirmButtonClass: "btn-raised btn-success",
		confirmButtonText: "OK",
	});
}

function alert_fail_save() {
	swal({
		title: "Alert!",
		text: "Data gagal tersimpan!",
		type: "error",
		confirmButtonClass: "btn-raised btn-danger",
		confirmButtonText: "OK",
	});
}

function alert_success_delete() {
    swal({
      title: "Success!",
      text: "Data telah terhapus!",
      type: "success",
      confirmButtonClass: "btn-raised btn-success",
      confirmButtonText: "OK",
    });
}

function alert_fail_delete() {
	swal({
		title: "Alert!",
		text: "Data gagal terhapus!",
		type: "error",
		confirmButtonClass: "btn-raised btn-danger",
		confirmButtonText: "OK",
	});
}
//END ALERT FUNCTION