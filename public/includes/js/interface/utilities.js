function createDropdownForOffices(selectContainer)
{
    return axios.get('/axios/offices')
    .then(response => {
        var data = response.data;

        data.forEach(function (index) {
            selectContainer.append('' +
                '<option value="'+ index.id +'">'+ index.name +'</option>'
            );
        });
    })
}

function delay(callback, ms) {
    var timer = 0;
    return function() {
      var context = this, args = arguments;
      clearTimeout(timer);
      timer = setTimeout(function () {
        callback.apply(context, args);
      }, ms || 0);
    };
  }
