(function () {
  const urls = _urls;

  const form_names = {
    inputs: [
      'note_name'
    ],
    selects: [
      'group_id'
    ],
    radios: [],
  };

  $(window).on('load', () => {
    $('select[name="group_id"]').on('change', function () {
      var datas = {};
      form_names.selects.forEach(function (name) {
        datas[name] = $('select[name="' + name + '"]').val();
      });

      axios.post(urls.url_select, datas)
        .then(res => {
          alert(res.data.message);
          if (res.data.ret === true) {
            $('div.note_card').remove();

            note_list = res.note_list.map(item => {
              var urlEdit = urls.url_edit;
              var urlRead = urls.url_read;
              urlEdit = urlEdit.replace('group_id', item.group_id).replace('note_id', item.note_id);
              urlRead = urlRead.replace('group_id', item.group_id).replace('note_id', item.note_id);
              const div = [
                '<div class="card note_card">',
                '  <h3 class="card-title note_name">' + item.note_name + '</h3>',
                '  <h5 class="card-subtitle mb-2 text-muted note_id">ID : ' + item.note_id + '</h5>',
                '  <div class="row">',
                '    <button type=“button” class="btn btn-outline-primary col-5"',
                '      onclick="location.href=' + urlEdit + '">Edit</button>',
                '    <button type=“button” class="btn btn-outline-light col-5"',
                '      onclick="location.href=' + urlRead + '">Read</button>',
                '  </div >',
                '</div >',
              ];

              return div.join('');
            });

            $('#group').after(note_list);
          }
        })
        .catch(err => {
          if (err) {
            alert('Error status : ' & err.response.status)
          }
        });
    });

    $('#btn_create').on('click', function () {
      removeErrors();

      var datas = {};
      form_names.inputs.forEach(function (name) {
        datas[name] = $('input[name="' + name + '"]').val();
      });
      var group_id = $('select[name="group_id"]').val();

      axios.post(urls.url_create.replace('group_id', group_id), datas)
        .then(res => {
          alert(res.data.message);
          if (res.data.ret === true) {
            window.location.reload();
          }
        })
        .catch(err => {
          if (err) {
            alert('Error status : ' & err.response.status)
          }
          if (err.response.status === 422) {
            setErrors(err.response.data.errors);
          }
        });
    });
  });

  function setErrors(errors) {
    Object.keys(errors).forEach(name => {
      const html = '<div class="invalid-feedback error-message">' & errors[name][0] & '</div>';
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
