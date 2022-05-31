$('.select2-multiple').select2({
  placeholder: "Pilih salah satu atau lebih",
  multiple: true
});

function formatRepo(repo) {
  if (repo.loading) return repo.text;
  var markup = "<div class='select2-result-repository clearfix'>" + "<div class='select2-result-repository__meta'>" + "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

  if (repo.description) {
      markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
  }

  markup += "<div class='select2-result-repository__statistics'>" + "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" + "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" + "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" + "</div>" + "</div></div>";
  return markup;
}

function formatRepoSelection(repo) {
  return repo.full_name || repo.text;
}

$("#kt_select2_6").select2({
  placeholder: "Search for git repositories",
  allowClear: true,
  ajax: {
      url: "https://api.github.com/search/repositories",
      dataType: 'json',
      delay: 250,
      data: function data(params) {
          return {
              q: params.term,
              page: params.page
          };
      },
      processResults: function processResults(data, params) {
          params.page = params.page || 1;
          return {
              results: data.items,
              pagination: {
                  more: params.page * 30 < data.total_count
              }
          };
      },
      cache: true
  },
  escapeMarkup: function escapeMarkup(markup) {
      return markup;
  },
  minimumInputLength: 1,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});

var KTTinymce = function () {
var uraian = function uraian() {
  tinymce.init({
    selector: '.uraian-tinymce',
    menubar: false,
    toolbar: ['styleselect fontselect fontsizeselect', 'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify', 'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code'],
    plugins: 'advlist autolink link image lists charmap print preview code',
    setup: function(editor) {
      editor.on('keyup', function() {
        _formEl.revalidateField('comment');
      });
    }
  });
};

return {
  init: function init() {
    uraian();
  }
};
}();

var KTWizard3 = function () {
var _wizardEl;
var _formEl;
var _wizard;
var _validations = [];

var initWizard = function initWizard() {
  _wizard = new KTWizard(_wizardEl, {
    startStep: 1,
    clickableSteps: true
  });

  _wizard.on('beforeNext', function (wizard) {
    _validations[wizard.getStep() - 1].validate().then(function (status) {
      if (status == 'Valid') {
        _wizard.goNext();

        KTUtil.scrollTop();
      } else {
        Swal.fire({
          text: "Sorry, looks like there are some errors detected, please try again.",
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Ok, got it!",
          customClass: {
            confirmButton: "btn font-weight-bold btn-light"
          }
        }).then(function () {
          KTUtil.scrollTop();
        });
      }
    });

    _wizard.stop(); // Don't go to the next step

  }); // Change event


  _wizard.on('change', function (wizard) {
    KTUtil.scrollTop();
  });
};

var initValidation = function initValidation() {
  // Step 1
  _validations.push(FormValidation.formValidation(_formEl, {
    fields: {
      klasifikasi: {
        validators: {
          notEmpty: {
            message: 'Klasifikasi harus dipilih'
          }
        }
      },
      sifat: {
        validators: {
          notEmpty: {
            message: 'Sifat tidak boleh kosong'
          }
        }
      },
      keamanan: {
        validators: {
          notEmpty: {
            message: 'Keamanan tidak boleh kosong'
          }
        }
      },
      tanggal: {
        validators: {
          notEmpty: {
            message: 'Tanggal tidak boleh kosong'
          }
        }
      },
      perihal: {
        validators: {
          notEmpty: {
            message: 'Perihal tidak boleh kosong'
          }
        }
      },
      kepada: {
        validators: {
          notEmpty: {
            message: 'Kepada tidak boleh kosong'
          }
        }
      },
      perhatian: {
        validators: {
          notEmpty: {
            message: 'Perhatian tidak boleh kosong'
          }
        }
      },
      lokasi: {
        validators: {
          notEmpty: {
            message: 'Lokasi tidak boleh kosong'
          }
        }
      },
      tembusan: {
        validators: {
          notEmpty: {
            message: 'Tembusan tidak boleh kosong'
          }
        }
      },
      uraian: {
        validators: {
          callback: {
              message: 'The comment must be between 5 and 200 characters long',
              callback: function(value) {
                  const text = tinyMCE.activeEditor.getContent({
                      format: 'text'
                  });
                  return text.length <= 200 && text.length >= 5;
              }
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap: new FormValidation.plugins.Bootstrap()
    }
  })); // Step 2


  _validations.push(FormValidation.formValidation(_formEl, {
    fields: {
      "package": {
        validators: {
          notEmpty: {
            message: 'Package details is required'
          }
        }
      },
      weight: {
        validators: {
          notEmpty: {
            message: 'Package weight is required'
          },
          digits: {
            message: 'The value added is not valid'
          }
        }
      },
      width: {
        validators: {
          notEmpty: {
            message: 'Package width is required'
          },
          digits: {
            message: 'The value added is not valid'
          }
        }
      },
      height: {
        validators: {
          notEmpty: {
            message: 'Package height is required'
          },
          digits: {
            message: 'The value added is not valid'
          }
        }
      },
      packagelength: {
        validators: {
          notEmpty: {
            message: 'Package length is required'
          },
          digits: {
            message: 'The value added is not valid'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap: new FormValidation.plugins.Bootstrap()
    }
  })); // Step 3


  _validations.push(FormValidation.formValidation(_formEl, {
    fields: {
      delivery: {
        validators: {
          notEmpty: {
            message: 'Delivery type is required'
          }
        }
      },
      packaging: {
        validators: {
          notEmpty: {
            message: 'Packaging type is required'
          }
        }
      },
      preferreddelivery: {
        validators: {
          notEmpty: {
            message: 'Preferred delivery window is required'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap: new FormValidation.plugins.Bootstrap()
    }
  })); // Step 4


  _validations.push(FormValidation.formValidation(_formEl, {
    fields: {
      locaddress1: {
        validators: {
          notEmpty: {
            message: 'Address is required'
          }
        }
      },
      locpostcode: {
        validators: {
          notEmpty: {
            message: 'Postcode is required'
          }
        }
      },
      loccity: {
        validators: {
          notEmpty: {
            message: 'City is required'
          }
        }
      },
      locstate: {
        validators: {
          notEmpty: {
            message: 'State is required'
          }
        }
      },
      loccountry: {
        validators: {
          notEmpty: {
            message: 'Country is required'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap: new FormValidation.plugins.Bootstrap()
    }
  }));
};

return {
  // public functions
  init: function init() {
    _wizardEl = KTUtil.getById('kt_wizard_v3');
    _formEl = KTUtil.getById('kt_form');
    initWizard();
    initValidation();
  }
};
}();

jQuery(document).ready(function () {
  KTWizard3.init();
  KTTinymce.init();
});