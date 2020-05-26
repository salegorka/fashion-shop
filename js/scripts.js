'use strict';

// Класс реализующий логику фильтра товаров, а также логику отправки запросов за товарами

class Filter {

  constructor(categoryId, page, catSale, catNew, priceLow, priceHigh, order, sort) {
    this.categoryId = categoryId;
    this.page = page;
    this.catSale = catSale;
    this.catNew = catNew;
    this.priceLow = priceLow;
    this.priceHigh = priceHigh;
    this.order = order;
    this.sort = sort;
  }

  sendRequestForGoods(callback) {

    let url = "/api/getGoods.php";
    url = url + `?category_id=${this.categoryId}`;
    url = url + `&page=${this.page}`;
    url = url + `&priceLow=${this.priceLow}`;
    url = url + `&priceHigh=${this.priceHigh}`;
    url = url + `&sale=${this.catSale}`;
    url = url + `&new=${this.catNew}`;
    url = url + `&order=${this.order}`;
    url = url + `&sort=${this.sort}`;

    $.ajax({
      url: url,
      type: 'GET',
      dataType: "html",
      success: callback,
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Ошибка AJAX запроса " + textStatus);
      }
    })

  }

  sendRequestForCount(callback) {

    let url = "/api/countGoods.php";
    url = url + `?category_id=${this.categoryId}`;
    url = url + `&priceLow=${this.priceLow}`;
    url = url + `&priceHigh=${this.priceHigh}`;
    url = url + `&sale=${this.catSale}`;
    url = url + `&new=${this.catNew}`;

    $.ajax({
      url: url,
      type: 'GET',
      dataType: "json",
      success: callback,
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Ошибка AJAX запроса " + textStatus);
      }
    })

  }

}

// Класс реализующий логику пагинации

class Pagination {

  constructor(pageCount) {
    this.pageCount = pageCount;
  }

  create(paginationEl, currentPage) {
    paginationEl.innerHTML = "";
    for (let i = 1; i <= this.pageCount; i++) {
      let newEl = document.createElement('li');
      newEl.innerHTML = currentPage == i ? `<a class="paginator__item active-page" data-page='${i}'>${i}</a>` : 
      `<a class="paginator__item" data-page='${i}' href='##'>${i}</a>`;
      paginationEl.append(newEl);
    }

    paginationEl.addEventListener('click', (event) => {
      event.preventDefault;
      if (event.target.dataset['page'] != undefined) {
        let activePage = document.querySelector(".active-page");
        activePage.setAttribute('href', '##');
        activePage.classList.remove("active-page");
        Goodfilter.page = event.target.dataset['page'];
        event.target.removeAttribute('href');
        event.target.classList.add("active-page");
        Goodfilter.sendRequestForGoods(function (respond, textStatus) {
          shopList.innerHTML = respond;
        })
      } else {
        return false;
      }
    }) 
  }

}



// Парсинг url чтобы получить значение категории или раздел новинки или распродажа

let categoryName = location.pathname.split('/')[2];
let categoryId;
let catSale = 0;
let catNew = 0;
if (categoryName === undefined) {
  categoryId = 0;
  if (location.pathname.split('/')[1] === 'new') {
    catNew = 1;

    //kjk

  }
  if (location.pathname.split('/')[1] === 'sale') {
    catSale = 1;
  }
} else {
  let categoryList = document.querySelectorAll(".filter__list-item");
  categoryList.forEach((value) => {
    value.classList.remove("active");
    if (value.dataset['name'] === categoryName) {
      value.classList.add("active");
      categoryId = value.dataset['id'];
    }
  })
}

// Инициализация фильтра

let Goodfilter = new Filter(categoryId, 1, catSale, catNew, 0, 40000, "", "ASC");


let shopFilter = document.querySelector(".shop__filter");
if (shopFilter) {

  // Изменение параметров фильтра для чекбоксов новинка и распродажа

  let inputNew = shopFilter.querySelector('input[id="new"]');
  if (Goodfilter.catNew == 1) {
    inputNew.checked = true;
  }
  inputNew.addEventListener('change', (event) => {
    if(inputNew.checked) {
      Goodfilter.catNew = 1;
    } else {
      Goodfilter.catNew = 0;
    }
  })

  let inputSale = shopFilter.querySelector('input[id="sale"]');
  if (Goodfilter.catSale == 1) {
    inputSale.checked = true;
  }
  inputSale.addEventListener('change', (event) => {
    if(inputSale.checked) {
      Goodfilter.catSale = 1;
    } else {
      Goodfilter.catSale = 0;
    }
  })

  // Изменение параметров фильтра при изменение порядка и поля сортировки

  let shopSorting = document.querySelector(".shop__sorting");
  let selectSortCategory = shopSorting.querySelector('select[name="category"]');
  selectSortCategory.addEventListener('change', (event) => {
    Goodfilter.order = event.target.value;
  })
  let selectSort = shopSorting.querySelector('select[name="sort"]');
  selectSort.addEventListener('change', (event) => {
    Goodfilter.sort = event.target.value;
  })

  //Отправка запросов при нажатии на кнопку "Применить"

  let buttonSubmit = shopFilter.querySelector(".button");

  buttonSubmit.addEventListener('click' , (event) => {
    event.preventDefault();
    Goodfilter.sendRequestForCount(function (respond, textStatus) {
      let resSort = document.querySelector(".res-sort");
      resSort.innerText = respond.text;

      // создание переключателя страниц
      console.log(respond.count);
      let pagination = new Pagination(Math.ceil(respond.count / 9));
      pagination.create(document.querySelector(".shop__paginator"), Goodfilter.page);

    })
    Goodfilter.sendRequestForGoods(function (respond, textStatus) {
      shopList.innerHTML = respond;
    })
  })
}


const toggleHidden = (...fields) => {

  fields.forEach((field) => {

    if (field.hidden === true) {

      field.hidden = false;

    } else {

      field.hidden = true;

    }
  });
};

const labelHidden = (form) => {

  form.addEventListener('focusout', (evt) => {

    const field = evt.target;
    const label = field.nextElementSibling;

    if (field.tagName === 'INPUT' && field.value && label) {

      label.hidden = true;

    } else if (label) {

      label.hidden = false;

    }
  });
};

const showLabel = (input) => {
  const label = input.nextElementSibling;
  if (!input.value) {
    label.hidden = false;
  }
}

const toggleDelivery = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  delivery.addEventListener('change', (evt) => {

    if (evt.target.id === 'dev-no') {

      fields.forEach(inp => {
        if (inp.required === true) {
          inp.required = false;
        }
      });


      toggleHidden(deliveryYes, deliveryNo);

      deliveryNo.classList.add('fade');
      setTimeout(() => {
        deliveryNo.classList.remove('fade');
      }, 1000);

    } else {

      fields.forEach(inp => {
        if (inp.required === false) {
          inp.required = true;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      deliveryYes.classList.add('fade');
      setTimeout(() => {
        deliveryYes.classList.remove('fade');
      }, 1000);
    }
  });
};

const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

  filterWrapper.addEventListener('click', evt => {

    const filterList = filterWrapper.querySelectorAll('.filter__list-item');

    filterList.forEach(filter => {

      if (filter.classList.contains('active')) {

        filter.classList.remove('active');

      }

    });

    const filter = evt.target;

    filter.classList.add('active');

  });

}


//

let order = {
  delivery: "dev-no",
  pay: "card"
};

// Обработчик для полей формы заказа

let pageOrder = document.querySelector(".shop-page__order");
if (pageOrder) {

  pageOrder.addEventListener('change', (event) => {

    let name = event.target.getAttribute('name');
    let value = event.target.value;

    order = {
      ...order,
      [name]: value
    }

  })

}


const shopList = document.querySelector('.shop__list');
if (shopList) {

  // Отправка запроса на загрузку товаров при загрузке старницы и для подсчета количества товаров

  window.onload = (event) => {
    Goodfilter.sendRequestForCount(function (respond, textStatus) {
      let resSort = document.querySelector(".res-sort");
      resSort.innerText = respond.text;

      // создание переключателя страниц
      let pagination = new Pagination(Math.ceil(respond.count / 9));
      pagination.create(document.querySelector(".shop__paginator"), Goodfilter.page);

    })
    Goodfilter.sendRequestForGoods(function (respond, textStatus) {
      shopList.innerHTML = respond;
    })
  }


  shopList.addEventListener('click', (evt) => {

    const prod = evt.path || (evt.composedPath && evt.composedPath());;

    if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {

      // Добавление в заказ информации о товаре

      let productName = evt.target.querySelector(".product__name").innerText;
      let productPrice = evt.target.querySelector(".product__price").innerText;
      productPrice = productPrice.slice(0, productPrice.length - 4);

      order = {
        ...order,
        productName,
        productPrice,
      }

      const shopOrder = document.querySelector('.shop-page__order');

      toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

      window.scroll(0, 0);

      shopOrder.classList.add('fade');
      setTimeout(() => shopOrder.classList.remove('fade'), 1000);

    }
  });

  const shopOrder = document.querySelector('.shop-page__order');
  const form = shopOrder.querySelector('.custom-form');
  labelHidden(form);
  toggleDelivery(shopOrder);

  const buttonOrder = shopOrder.querySelector('.button');
  const popupEnd = document.querySelector('.shop-page__popup-end');

  buttonOrder.addEventListener('click', (evt) => {

    const shopOrder = document.querySelector('.shop-page__order');
    const form = shopOrder.querySelector('.custom-form');

    form.noValidate = true;

    console.log("ЗАказ");

    const inputs = Array.from(shopOrder.querySelectorAll('[required]'));

    inputs.forEach(inp => {

      if (!!inp.value) {

        if (inp.classList.contains('custom-form__input--error')) {
          inp.classList.remove('custom-form__input--error');
        }

      } else {

        inp.classList.add('custom-form__input--error');

      }
    });

    if (inputs.every(inp => !!inp.value)) {

      // Отправка заказа
      evt.preventDefault();

      let url = '/api/createOrder.php';
      let data = order;
      $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function ( respond, textStatus, jqXHR) {
          if (respond.success == true) {

            // Очистка текстовых полей формы

            const textInputs = Array.from(shopOrder.querySelectorAll('.custom-form__input'));
            textInputs.forEach((input) => {
              input.value = '';
              showLabel(input);
              delete(order[input.getAttribute('name')]);
            })
            const textArea = shopOrder.querySelector('textarea');
            textArea.value = '';
            delete(order[textArea.getAttribute('name')]);

            toggleHidden(shopOrder, popupEnd);

            popupEnd.classList.add('fade');
            setTimeout(() => popupEnd.classList.remove('fade'), 1000);

            window.scroll(0, 0);

          } else {
            console.log(textStatus, respond);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Ошибка AJAX запроса " + textStatus);
        }
      })

    } else {
      window.scroll(0, 0);
      evt.preventDefault();
    }
  });

  const buttonEnd = popupEnd.querySelector('.button');

  buttonEnd.addEventListener('click', () => {

    popupEnd.classList.add('fade-reverse');

    setTimeout(() => {

      popupEnd.classList.remove('fade-reverse');

      toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));

    }, 1000);

  });


}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

  pageOrderList.addEventListener('click', evt => {


    if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
      var path = evt.path || (evt.composedPath && evt.composedPath());
      Array.from(path).forEach(element => {

        if (element.classList && element.classList.contains('page-order__item')) {

          element.classList.toggle('order-item--active');

        }

      });

      evt.target.classList.toggle('order-item__toggle--active');

    }

    if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {

      let id = evt.target.dataset['id'];

      const status = evt.target.previousElementSibling;
      let newStatus = '';

      if (status.classList && status.classList.contains('order-item__info--no')) {
        newStatus = 'Выполнено';
      } else {
        newStatus = 'Не выполнено';
      }

      // отправка запроса на изменение статуса заказа

      let url = '/api/changeOrder.php';
      let data = { id , newStatus };
      $.ajax({
        url: url,
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        xhrFields: { withCredentials:true },
        success: function (respond, textStatus) {
          console.log(respond);
          if (respond.success == true) {
            const status = evt.target.previousElementSibling;

            if (status.classList && status.classList.contains('order-item__info--no')) {
              status.textContent = 'Выполнено';
            } else {
              status.textContent = 'Не выполнено';
            }

            status.classList.toggle('order-item__info--no');
            status.classList.toggle('order-item__info--yes');

          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Ошибка AJAX запроса " + textStatus);
        }
      })

    }

  });

}

const checkList = (list, btn) => {

  if (list.children.length === 1) {

    btn.hidden = false;

  } else {
    btn.hidden = true;
  }

};
const addList = document.querySelector('.add-list');
if (addList) {

  const form = document.querySelector('.custom-form');
  labelHidden(form);

  const addButton = addList.querySelector('.add-list__item--add');
  const addInput = addList.querySelector('#product-photo');

  checkList(addList, addButton);

  addInput.addEventListener('change', evt => {

    const template = document.createElement('LI');
    const img = document.createElement('IMG');

    template.className = 'add-list__item add-list__item--active';
    template.addEventListener('click', evt => {
      addList.removeChild(evt.target);
      addInput.value = '';
      checkList(addList, addButton);
    });

    const file = evt.target.files[0];
    const reader = new FileReader();

    reader.onload = (evt) => {
      img.src = evt.target.result;
      template.appendChild(img);
      addList.appendChild(template);
      checkList(addList, addButton);
    };

    reader.readAsDataURL(file);

  });

  const button = document.querySelector('.button');
  const popupEnd = document.querySelector('.page-add__popup-end');

  button.addEventListener('click', (evt) => {

    evt.preventDefault();

// Отправка запроса на добавление товара в бд 
    const data = new FormData(form);
    console.log(form);
 
    let url = '';

    if (form.getAttribute('name') === 'add') {
      url = '/api/createGood.php';
    } else if (form.getAttribute('name') === 'change') {
      url = '/api/updateGood.php';
      data.append('id', button.dataset.id);
      console.log(button.dataset.id);
    };

    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      cache: false,
      dataType: 'json',
      processData: false,
      xhrFields: { withCredentials:true },
      contentType: false,
      success: function ( respond, textStatus, jqXHR) {
        if (respond.error === undefined) {
          console.log(textStatus, respond);
          form.hidden = true;
          popupEnd.hidden = false;
        } else {
          let errorField = form.querySelector('.custom_form__error-field');
          errorField.innerText = respond.error;
          errorField.hidden = false;
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Ошибка AJAX запроса " + textStatus);
      }
    })

    

  })

}

const productsList = document.querySelector('.page-products__list');
if (productsList) {

  productsList.addEventListener('click', evt => {

    const target = evt.target;

    if (target.classList && target.classList.contains('product-item__delete')) {

      console.log(target.dataset['id']);

      let url = '/api/deleteGood.php';
      let data = { id: target.dataset['id']};
      $.ajax({
        url: url,
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        xhrFields: { withCredentials:true },
        success: function ( respond, textStatus, jqXHR) {
          if (respond.success == true) {
            productsList.removeChild(target.parentElement);
          } else {
            console.log(textStatus, respond);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Ошибка AJAX запроса " + textStatus);
        }
      })
      
      //  productsList.removeChild(target.parentElement);

    }

  });

}

// jquery range maxmin
if (document.querySelector('.shop-page')) {

  $('.range__line').slider({
    min: 350,
    max: 32000,
    values: [350, 32000],
    range: true,
    stop: function(event, ui) {

      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');

      Goodfilter.priceLow = $('.range__line').slider('values', 0);
      Goodfilter.priceHigh = $('.range__line').slider('values', 1);

    },
    slide: function(event, ui) {

      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');

    }
  });

}



