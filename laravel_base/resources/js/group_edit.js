const { isBuffer } = require("lodash");

(function () {
  const urls = _urls;

  const form_names = {
    inputs: [
      'is_create',
      'group_id',
      'group_name',
      'group_pass',
      'group_pass_confirmation',
      'sign_group_pass',
    ],
    selects: [],
    checks: [
      'change_pass',
    ],
    radios: [],
  };

  $(window).on('load', () => {
    $('#change_pass').on('change', function () {
      m.switchDNone('pass_update', $(this).prop('checked'));
    });

    $('#btn_create').on('click', function () {
      removeErrors();

      var datas = {};
      form_names.inputs.forEach(function (name) {
        datas[name] = $('input[name="' + name + '"]').val();
      });

      var url_commit = urls.url_create;

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

    $('#btn_update').on('click', function () {
      removeErrors();

      var datas = {};
      form_names.inputs.forEach(function (name) {
        datas[name] = $('input[name="' + name + '"]').val();
      });
      form_names.checks.forEach(function (name) {
        datas[name] = $('input[name="' + name + '"]').prop('checked');
      });

      var url_commit = urls.url_update;

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
      form_names.inputs.forEach(function (name) {
        datas[name] = $('input[name="' + name + '"]').val();
      });

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
      const html = '<div class="invalid-feedback">' + errors[name][0] + '</div>';
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
