# cv
Логин и пароль для входа в демо приложение которое находится по адресу http://comprenova.ru Login: user@user.loc password: 12345678

Приложение является элементарным блогом с помощью которого продемонстрировны возможности Laravel для написания кода, 
следование принципам SOLID, применение паттернов проектирования, базовые навыки работы с фронтенд технологиями, навыки 
построения оптимальной схемы БД.

В демо приложении реализованы следующие вещи

1. Принципы SOLID Контроллеры реализуют только прием Request и отдачу Response, валидация 
вынесена в отдельный класс, логика вынесена в сервисные классы, с помощью паттерна Репозиторий 
реализована инверсия зависимостей что сделало код приложения независимым от типа хранилища. Это 
делает приложение хорошо подготовленным к развитию, вы можете спокойно расширять сервисный слой необходимым функционалом, т.к.
этот слой является слабо связанным с другими частями приложения. Таким образом, развитие приложения может 
идти последовательно и без проблем.

2. На примере реализации мультиязычности (можно добавлять неограниченное число языков) показаны возможности
Laravel по переводам статического контента, но что более интересно как спроектирована схема БД для хранения
мультиязычного динамического контента. Кроме того, реализовано взаимодействие с JS плагинами для передачи в них
мультиязычного контента (DataTable, Dropzone и проч). 

3. Админка собрана на bootstrap 4, написаны JS модули для конфигурирования и подключения jQuery плагинов

В перспективе планируется добавить функционал для деплоя на удаленный сервер с нулевым временем простоя.

Написать REST API для обращения к блогу из внешних сервисов.

# Build an API with Laravel

- Writing JSON:API Specification
- Planning our API
- Selection of authentication system
- Writing the actual API
- Writing tests for the API

## JSON:API specification

JSON:API specification is the document structure of data for JSON:API request and responses. The document 
describes how our JSON data should be formed, how members should named, where these should be placed and so 
forth.

**Top-level of the document**

JSON:API Specification states that there must be a JSON object at the root of the document, representing the 
top-level.

In the top-level of the document, there must be at least one of the following members:

- **data** - which is the most important member that contains the primary data of the document.
- **errors** - which is a member that contains all errors objects.
- **included** - which is a member that contains all resource objects that are related to the primary data 
and/or related to each other.
- **jsonapi** - which is a member that contains the server's implementation of the JSON:API Specification
- **meta** - which is a member that contains  all non-standard meta information.

Note that it is very important that the **data** and **errors** members never coexists in the same document.

**Primary data and Resource objects**

For definiteness, let's take the real single **categories** resource. 

`GET: en/tags/1`
```json
{
    "data": {
        "id": "1",
        "type": "categories",
        "attributes": {
            "alias": "any_category",
            "locale": "en",
            "name": "Any Category",
            "created_at": "2021-02-01 16:51:03",
            "updated_at": "2021-02-01 16:51:03"
        },
        "relationships": {
            "translations": {
                "links": {
                    "self": "http://cv.local/categories/1/relationships/translations",
                    "related": "http://cv.local/categories/1/translations"
                },
                "data": [
                    {
                        "id": "1",
                        "type": "category_translations"
                    },
                    {
                        "id": "2",
                        "type": "category_translations"
                    }
                ]  
            }
        }
    },
    "included": [
        {
            "id": "1",
            "type": "category_translations",
            "attributes": {
                "category_id": "1",
                "locale": "en",
                "name": "Any Category"
            }
        },
        {
            "id": "2",
            "type": "category_translations",
            "attributes": {
                "category_id": "1",
                "locale": "ru",
                "name": "Какая-то категория"
            }
        }
    ]
}
```
We have a clear structure now. In the root of the resource object you'll find:

- **id** - which is the id of the resource as a string
- **type** - which is the type of the resource as a string
- **attributes** - which contains all of the attributes of our resource
- **relationships** - which contains all of the relationships of our resource

It's ok for the **attributes** and **relationships** members to be empty. In fact, these can be removed if 
not used. But, as an absolute minimum, you should always have the **id** and **type** members in your 
resource objects, and the value of both should always be a string.

Note, there is a difference between requesting a collection of resources versus requesting a single resource.
If we are requesting the collection of resources the **data** member of the returned document should be 
structured like this:

`GET: tags`
```json
{
  "data": [
    {
      "id": "1",
      "type": "tags",
      "attributes": {
      },
      "relationships": {
      }
    },
    {
       "id": "2",
       "type": "tags",
       "attributes": { 
       },
       "relationships": {
       }
     }
  ]
}
```
Here, the **data** member is an array containing the requested resource objects.

Now, let's take a look at **relationships** member. A **relatiomships** member must contain at least one of the 
following members:

- **links**
- **-self**
- **-related**
- **data**
- **meta**

Let's take a look at **links** member. This member contains two types of links. 

- The link for the **self** member is a link for the relationship itself. 
- The link for the **related** member is a link for the relation between resources.

The **data** member is something we have seen before, yet this one is a little different. It's called the 
**resource linkage** and instead of holding **resorce objects**, it holds **resource identifier objects**.
In contrast to resource objects, which hold **id type attributes relationships** members, resource identifier 
objects only contain the **id** and **type** members of the related resource objects.

The **meta** member is a meta object that can contain non-standard metadata about the relationship

Let's take a look the relstionship between a **tag** and a **post**
```json
{
  "data": {
    "id": "1",
    "type": "tags",
    "attributes": {
      "name": "any tag"
    },
    "relationships": {
      "posts": {
        "links": {
          "self": "http://example.com/tags/1/relationships/posts",
          "related": "http://example.com/tags/1/posts"
        },
        "data": [
            {
              "id": "5",
              "type": "posts"
            },
            {
              "id": "10",
              "type": "posts"
            }
        ]
      }
    }
  }
}
```
OK, let's take look at requesting **posts** resource. It will be mush more interesting, because of that 
**posts** resource has relationships with **tags categories users** resources at the same time. 
Look at, please:

`GET: posts/1`
```json
{
  "data": {
    "id": "1",
    "type": "posts",
    "attributes": {
      "title": "My first post",
      "text": "I have written my first post"
    },
    "relationships": {
      "tags": {
        "links": {
          "self": "http://example.com/posts/1/relationships/tags",
          "related": "http://example.com/posts/1/tags"
        },
        "data": [
            {
              "id": "5",
              "type": "tags"
            },
            {
              "id": "10",
              "type": "tags"
            }
        ]
      },
      "categories": {
         "links": {
           "self": "http://example.com/posts/1/relationships/categories",
           "related": "http://example.com/posts/1/categories"
         },
         "data": {
           "id": "2",
           "type": "categories"
         }
      },
      "users": {
        "links": {
          "self": "http://example.com/posts/1/relationships/users",
          "related": "http://example.com/posts/1/users"
        },
        "data": {
          "id": "23",
          "type": "users"
        }
      }
    }
  }
}
```

## Testing API

**A test is divided into 3 parts**

- In the first part we set up our world
- I n the second part we run the code to be tested
- In the third part we make all of our assertions

**Testing of request headers**

The GET request needs to test only Accept header, so we have these tests:

- It aborts GET request if an Accept header does not adhere to the json API specification
- It accepts GET request if an Accept header adhere to the json API specification
- It ensures GET request 
