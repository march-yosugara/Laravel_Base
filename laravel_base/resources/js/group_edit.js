const { isBuffer } = require("lodash");

(function () {
  const urls = _urls;

  const form_names = {
    inputs: [
      'group_id',
      'group_name',
      'group_pass',
      'group_pass_confirmation',
    ],
    selects: [],
    radios: [],
  };

  $(window).on('load', () => {
    $('#btn_commit').on('click', function () {
      removeErrors();

      var datas = {};
      form_names.inputs.forEach(function (name) {
        datas[name] = $('input[name="' + name + '"]').val();
      });

      var url_commit = '';
      if (isCreate === '1') {
        url_commit = urls.url_create;
      }
      else {
        url_commit = urls.url_update;
      }

      axios.post(url_commit, datas)
        .then(res => {
          alert(res.data.message);
          if (res.data.ret === true) {
            window.location.href = urls.url_manage;
          }
        })
        .catch(err => {
          if (err) {
            alert('Error status : ' + err.response.status);
          }
          if (err.response.status === 422) {
            setErrors(err.response.data.errors);
          }
        });
    });

    $('#btn_delete').on('click', function () {
      removeErrors();

      var datas = {};
      datas['group_id'] = $('input[name="group_id"]').val();

      axios.post(urls.url_delete, datas)
        .then(res => {
          alert(res.data.message);
          if (res.data.ret === true) {
            window.location.href = urls.url_manage;
          }
        })
        .catch(err => {
          if (err) {
            alert('Error status : ' + err.response.status);
          }
        });
    });
  });

  function setErrors(errors) {
    Object.keys(errors).forEach(name => {
      const html = '<div class="invalid-feedback error-message">' + errors[name][0] + '</div>';
      const target = $('[name="' + name + '"]');
      target.addClass('is-invalid');
      target.after(html);
    });
  }

  function removeErrors() {
    $('div.invalid-feedback').remove();
    $('.is-invalid').removeClass('is-invalid');
  }

})();
