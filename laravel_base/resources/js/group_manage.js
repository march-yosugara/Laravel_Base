(function () {
  const urls = _urls;

  const form_names = {
    inputs: [
      'add_group_id',
      'add_group_pass',
    ],
    selects: [],
    radios: [
      'search_type',
    ],
  };

  $(window).on('load', () => {
    $('#btn_add').on('click', function () {
      var datas = {};
      form_names.inputs.forEach(function (name) {
        datas[name] = $('input[name="' + name + '"]').val();
      });
      form_names.radios.forEach(function (name) {
        datas[name] = $('input[name="' + name + '"]:checked').val();
      });

      axios.post(urls.url_add, datas)
        .then(res => {
          alert(res.data.message);
          if (res.data.ret === true) {
            window.location.reload();
          }
        })
        .catch(err => {
          if (err) {
            alert('Error status : ' + err.response.status);
          }
        });
    });

    $('.btn_remove').on('click', function () {
      var datas = {};
      datas['group_id'] = $(this).attr('name');

      axios.post(urls.url_remove, datas)
        .then(res => {
          alert(res.data.message);
          if (res.data.ret === true) {
            window.location.reload();
          }
        })
        .catch(err => {
          if (err) {
            alert('Error status : ' + err.response.status);
          }
        });
    });
  });

})();
