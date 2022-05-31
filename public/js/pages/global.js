"use strict";
let base_url = $(location).attr('pathname');
base_url.indexOf(1);
base_url.toLowerCase();
base_url = (window.location.origin === "http://103.9.227.61:8000/" ? "" : base_url.split("/")[0]);
let site_url = window.location.origin + "/" + base_url;
let validator;

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    }
});

window.convertToRupiahJs = function (angka) {
    let angka2 = angka.replace('.00', '');
    let rupiah = '';
    let angkarev = angka2.toString().split('').reverse().join('');
    for (let i = 0; i < angkarev.length; i++)
        if (i % 3 === 0)
            rupiah += angkarev.substr(i, 3) + '.';
    return rupiah.split('', rupiah.length - 1).reverse().join('');
}

window.initSelect2 = function (selector) {
    $(selector).select2({
        placeholder: "Pilih salah satu"
    });
}

window.initSelect2Tag = function (selector) {
    $(selector).select2({
        tags: true,
		tokenSeparators: [','],
		language: {
            inputTooShort: function () {
                return "";
            },
            searching: function () {
                return "";
            },
            noResults: function () {
                return "";
            },
        },
    });
}

window.initSebutanPengganti = function (selector) {
	var data = [
		{
			id: "",
			text: '-'
		},
		{
			id: "Pj.",
			text: 'Pj.'
		},
		{
			id: "Pjs.",
			text: 'Pjs.'
		}
	];
    $(selector).select2({
        data: data,
		language: {
            inputTooShort: function () {
                return "";
            },
            searching: function () {
                return "";
            },
            noResults: function () {
                return "";
            },
        },
    });
}

window.initTinyMCE = function (selector) {
    tinymce.init({
        selector: selector,
		height: "450",
        menubar: false,
        toolbar: ['bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table'],
        plugins: 'lists table',
		fontsize_formats: '10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt', 
        pagebreak_separator : '<div class="break"></div>',
    });
}

window.initDataTable = function (selector) {
    $(selector).DataTable({
        responsive: true,
        dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
        lengthMenu: [5, 10, 25, 50],
        pageLength: 10,
        info: false,
        language: {
            'lengthMenu': 'Display _MENU_'
        },
        order: [
            [0, 'asc']
        ],
        columnDefs: []
    });
}

window.initProsesTipe = function(selector){
	let process = [{id: "persetujuan",text: "Persetujuan"},{id: "administrasi",text: "Administrasi"}];
	$(selector).select2({
		placeholder: 'Proses',
		minimumInputLength: 0,
		allowClear: true,
		quietMillis: 100,
		multiple: false,
		data : process,
		escapeMarkup: function (markup) { return markup; }
	});
}

window.initKlasifikasi = function (selector) {
    $(selector).select2({
        placeholder: 'Cari Klasifikasi Surat',
        minimumInputLength: 1,
        allowClear: true,
        multiple: false,
        language: {
            inputTooShort: function () {
                return 'Masukkan minimal 2 huruf';
            }
        },
        ajax: {
            dataType: "json",
            url: site_url + 'get-klasifikasi-surat',
            type: 'POST',
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: '<b>' + item.kode + '</b> - ' + item.name,
                            list: '<b>' + item.kode + '</b> - ' + item.name,
                            id: JSON.stringify(item.id)
                        }
                    })
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: function (data) {
            return data.list;
        },
        templateSelection: function (data) {
            return data.text;
        }
    });

    if ($(selector).attr("data-id") != undefined) {
        var data = {
            id: $(selector).attr("data-id"),
            text: $(selector).attr("data-text")
        }

        var selected = new Option(data.text, data.id, false, false);
        $(selector).append(selected).trigger('change');
    }
}

window.initSifatSurat = function (selector) {
    $(selector).select2({
        placeholder: 'Pilih Sifat Surat',
        minimumInputLength: 0,
        multiple: false,
        language: {
            inputTooShort: function () {
                return 'Masukkan kata kunci';
            },
            searching: function () {
                return "Memuat data..";
            },
            noResults: function () {
                return "Data tidak ditemukan";
            },
        },
        ajax: {
            dataType: "json",
            url: site_url + 'get-sifat-surat',
            type: 'POST',
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: JSON.stringify(item.id)
                        }
                    })
                };
            },
            cache: true
        }
    });

    if ($(selector).attr("data-id") != "undefined") {
        var data = {
            id: $(selector).attr("data-id"),
            text: $(selector).attr("data-text")
        }

        var selected = new Option(data.text, data.id, false, false);
        $(selector).append(selected).trigger('change');
    }
}

window.initKeamananSurat = function (selector) {
    $(selector).select2({
        placeholder: 'Pilih Keamanan Surat',
        minimumInputLength: 0,
        multiple: false,
        language: {
            inputTooShort: function () {
                return 'Masukkan kata kunci';
            },
            searching: function () {
                return "Memuat data..";
            },
            noResults: function () {
                return "Data tidak ditemukan";
            },
        },
        ajax: {
            dataType: "json",
            url: site_url + 'get-keamanan-surat',
            type: 'POST',
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: JSON.stringify(item.id)
                        }
                    })
                };
            },
            cache: true
        },
    });

    if ($(selector).attr("data-id") != "") {
        var data = {
            id: $(selector).attr("data-id"),
            text: $(selector).attr("data-text")
        }

        var selected = new Option(data.text, data.id, false, false);
        $(selector).append(selected).trigger('change');
    }
}

window.initTipeTTD = function (selector) {
    $(selector).select2({
        placeholder: 'Pilih Tipe Tanda Tangan',
        minimumInputLength: 0,
        multiple: false,
		width: 'resolve',
        language: {
            inputTooShort: function () {
                return 'Masukkan kata kunci';
            },
            searching: function () {
                return "Memuat data..";
            },
            noResults: function () {
                return "Data tidak ditemukan";
            },
        },
        ajax: {
            dataType: "json",
            url: site_url + 'get-tipe-ttd',
            type: 'POST',
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        },
    });

    if ($(selector).attr("data-id") != "") {
        var data = {
            id: $(selector).attr("data-id"),
            text: $(selector).attr("data-text")
        }

        var selected = new Option(data.text, data.id, false, false);
        $(selector).append(selected).trigger('change');
    }
}

window.initKepada = function (selector) {
    $(selector).select2({
        placeholder: 'Cari Nama Dinas/OPD',
        minimumInputLength: 1,
        allowClear: true,
        multiple: true,
        language: {
            inputTooShort: function () {
                return 'Masukkan minimal 2 huruf';
            },
            searching: function () {
                return "Memuat data..";
            },
            noResults: function () {
                return "Data tidak ditemukan";
            },
        },
        ajax: {
            dataType: "json",
            url: site_url + 'get-kepada-opd',
            type: 'POST',
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data['result'], function (item) {
                        console.log(item);
                        return {
                            text: item.jabatan + ' [<b>'+item.nama_lengkap+'</b>]',
                            list: item.jabatan + ' [<b>'+item.nama_lengkap+'</b>]',
                            id: item.nip
                        }
                    })
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: function (data) {
            return data.list;
        },
        templateSelection: function (data) {
            return data.text;
        }
    });
}

window.initKepalaOPD = function (selector) {
    $(selector).select2({
        placeholder: 'Cari Nama Dinas/OPD',
        minimumInputLength: 1,
        allowClear: true,
        multiple: true,
        language: {
            inputTooShort: function () {
                return 'Masukkan minimal 2 huruf';
            },
            searching: function () {
                return "Memuat data..";
            },
            noResults: function () {
                return "Data tidak ditemukan";
            },
        },
        ajax: {
            dataType: "json",
            url: site_url + 'get-kepada-opd',
            type: 'POST',
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data['result'], function (item) {
                        console.log(item);
                        return {
                            text: item.jabatan,
                            list: item.jabatan,
                            id: item.nip
                        }
                    })
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: function (data) {
            return data.list;
        },
        templateSelection: function (data) {
            return data.text;
        }
    });
}

window.initJabatan = function (selector) {
    $(selector).select2({
        placeholder: 'Cari Pegawai',
        minimumInputLength: 1,
        allowClear: true,
        multiple: true,
        language: {
            inputTooShort: function () {
                return 'Masukkan minimal 2 huruf';
            },
            searching: function () {
                return "Memuat data..";
            },
            noResults: function () {
                return "Data tidak ditemukan";
            },
        },
        ajax: {
            dataType: "json",
            url: site_url + 'get-kepada-opd',
            type: 'POST',
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data['result'], function (item) {
                        console.log(item);
                        return {
                            text: item.jabatan + ' [<b>'+item.nama_lengkap+'</b>]',
                            list: item.jabatan + ' [<b>'+item.nama_lengkap+'</b>]',
                            id: item.lokasi
                        }
                    })
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: function (data) {
            return data.list;
        },
        templateSelection: function (data) {
            return data.text;
        }
    });
}

window.initTandaTangan = function (selector) {
    $(selector).select2({
        placeholder: 'Cari Pegawai',
        minimumInputLength: 1,
        allowClear: true,
        language: {
            inputTooShort: function () {
                return 'Masukkan minimal 2 huruf';
            },
            searching: function () {
                return "Memuat data..";
            },
            noResults: function () {
                return "Data tidak ditemukan";
            },
        },
        ajax: {
            dataType: "json",
            url: site_url + 'get-kepada-opd',
            type: 'POST',
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data['result'], function (item) {
                        console.log(item);
                        return {
                            text: item.jabatan + ' [<b>'+item.nama_lengkap+'</b>]',
                            list: item.jabatan + ' [<b>'+item.nama_lengkap+'</b>]',
                            id: item.nip
                        }
                    })
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: function (data) {
            return data.list;
        },
        templateSelection: function (data) {
            return data.text;
        }
    });
}

window.initTembusan = function (selector) {
    $(selector).select2({
        placeholder: 'Pilih Tumbusan',
        minimumInputLength: 1,
        allowClear: true,
        multiple: true,
        language: {
            inputTooShort: function () {
                return 'Masukkan minimal 2 huruf';
            },
            searching: function () {
                return "Memuat data..";
            },
            noResults: function () {
                return "Data tidak ditemukan";
            },
        },
        ajax: {
            dataType: "json",
            url: site_url + 'get-struktural-opd',
            type: 'POST',
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data['result'], function (item) {
                        console.log(item);
                        return {
                            text: item.nama_lengkap + '(<b>' + item.jabatan +'</b>)',
                            list: item.nama_lengkap + '(<b>' + item.jabatan +'</b>)',
                            id: JSON.stringify(item.nip)
                        }
                    })
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: function (data) {
            return data.list;
        },
        templateSelection: function (data) {
            return data.text;
        }
    });
}

window.initNaskah = function (selector) {
    $(selector).select2({
        placeholder: 'Cari Naskah Surat',
        allowClear: true,
        multiple: false,
        language: {
            inputTooShort: function () {
                return 'Masukkan minimal 2 huruf';
            },
            searching: function () {
                return "Memuat data..";
            },
            noResults: function () {
                return "Data tidak ditemukan";
            },
        },
        ajax: {
            dataType: "json",
            url: site_url + 'get-bentuk-surat/1',
            type: 'GET',
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama,
                            list: item.nama,
                            id: JSON.stringify(item.id)
                        }
                    })
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: function (data) {
            return data.list;
        },
        templateSelection: function (data) {
            return data.text;
        }
    });

}

window.initUploadLampiran = function (selector, buttonID) {
    let Tus = Uppy.Tus;
    let StatusBar = Uppy.StatusBar;
    let FileInput = Uppy.FileInput;
    let Informer = Uppy.Informer;
	let elemId = selector;
	let id = '#' + elemId;
	let $statusBar = $(id + ' .uppy-status');
	let $uploadedList = $(id + ' .uppy-list');
	let timeout;
	
	let uppyMin = Uppy.Core({
		debug: true,
		autoProceed: true,
		showProgressDetails: true,
		restrictions: {
			maxFileSize: 1000000,
			maxNumberOfFiles: 5,
			minNumberOfFiles: 1
		}
	});
	
	uppyMin.use(FileInput, {
		target: id + ' .uppy-wrapper',
		pretty: false
	});
	uppyMin.use(Informer, {
		target: id + ' .uppy-informer'
	});

	uppyMin.use(Tus, {
		endpoint: 'https://master.tus.io/files/'
	});
	uppyMin.use(StatusBar, {
		target: id + ' .uppy-status',
		hideUploadButton: true,
		hideAfterFinish: false
	});
	
	$(id + ' .uppy-FileInput-input').addClass('uppy-input-control').attr('id', elemId + '_input_control');
	let $fileLabel = $(buttonID);
	
	uppyMin.on('upload', function (data) {
		$fileLabel.text("Uploading...");
		$statusBar.addClass('uppy-status-ongoing');
		$statusBar.removeClass('uppy-status-hidden');
		clearTimeout(timeout);
	});
	let no = 0;
	
	uppyMin.on('complete', function (file) {
		$.each(file.successful, function (index, value) {
			no += 1;
			console.log(no);
			let sizeLabel = "bytes";
			let filesize = value.size;
			let ext = value.extension;

			if (filesize > 1024) {
				filesize = filesize / 1024;
				sizeLabel = "kb";

				if (filesize > 1024) {
					filesize = filesize / 1024;
					sizeLabel = "MB";
				}
			}

			let uploadListHtml = '<div class="uppy-list-item" ' + (no === 1 ? "style='margin-top: -30px'" : "") + ' data-id="' + value.id + '"><input type="text" class="form-control" name="filename[]" value="' + value.name + '" /><span style="font-size: 2em !important" class="uppy-list-remove" data-id="' + value.id + '"><i class="la la-trash text-danger" style="font-size: 1em !important"></i></span></div>';
			$uploadedList.append(uploadListHtml);
		});
		$fileLabel.html(`<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-07-07-181510/theme/html/demo1/dist/../src/media/svg/icons/Files/Upload.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24"/>
								<path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
								<rect fill="#000000" opacity="0.3" x="11" y="2" width="2" height="14" rx="1"/>
								<path d="M12.0362375,3.37797611 L7.70710678,7.70710678 C7.31658249,8.09763107 6.68341751,8.09763107 6.29289322,7.70710678 C5.90236893,7.31658249 5.90236893,6.68341751 6.29289322,6.29289322 L11.2928932,1.29289322 C11.6689749,0.916811528 12.2736364,0.900910387 12.6689647,1.25670585 L17.6689647,5.75670585 C18.0794748,6.12616487 18.1127532,6.75845471 17.7432941,7.16896473 C17.3738351,7.57947475 16.7415453,7.61275317 16.3310353,7.24329415 L12.0362375,3.37797611 Z" fill="#000000" fill-rule="nonzero"/>
							</g>
							</svg></span> Tambah File Lain`);
		$statusBar.addClass('uppy-status-hidden');
		$statusBar.removeClass('uppy-status-ongoing');
	});

	$(document).on('click', id + ' .uppy-list .uppy-list-remove', function () {
		let itemId = $(this).attr('data-id');
		uppyMin.removeFile(itemId);
		$(id + ' .uppy-list-item[data-id="' + itemId + '"').remove();
	});
}

jQuery(document).ready(function () {

});
