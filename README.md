# 🍎🥕 Fruits and Vegetables - Marco's test

Scroll down to see the original README. No ChatGPT was used to produce these documents,
I tend to document thoroughly and why not, with good formatting :)

## Approach

The base task was very simple, and I was undecided on how much to push. I decided to dare a bit, and:

- Dockerize the services as if it was a microservice
- Implement some DDD principles (on a single domain, as this
  is a single service that should be bounded)
  - among those, using the message bus to ship commands
- Implement CQRS, separating between Queries and Commands

Admittedly it's not very YAGNI nor I push any approach by default (most of the times I use a way more
vanilla skeleton and anyway evaluate case to case) but I wanted to showcase a bit of my reasoning on
things that become complex and scalable.

As for the implementation: fruits and vegetables are basically identical collections.
We could deal with this in different ways, keeping them independent or using the same table
with a polymorphic relationship.

## What I did in this fork

See `CHANGES.md` file!

## How to spin the environment

I am accustomed to having a Makefile to launch commands,
either from the host or inside the PHP container, so make
sure you have `make` installed.

```bash
git clone <this repo>
cd <this repo>
make upd               # launch services with Docker Compose
make db-init           # create schema and migrate
```

In case of errors with SSH_AUTH_SOCK, try:

```bash
eval $(ssh-agent)
```

to make sure SSH forwarding works.

## Play with the API

Use `vegetable` instead of `fruit` for the respective endpoints.

### Add item

```bash
curl --location 'localhost:8080/api/v1/fruit' \
  --header 'Content-Type: text/plain' \
  --data '{
      "name": "baz",
      "unit": "kg",
      "value": 65.0
  }'
```

### List items

```bash
curl --location 'localhost:8080/api/v1/fruit?name=foo&minWeight=500&maxWeight=8000'
```

### Add file

```bash
curl -X POST localhost:8080/api/v1/parse -d @./request.json
```

---

# Original README

## 🎯 Goal

We want to build a service which will take a `request.json` and:

- Process the file and create two separate collections for `Fruits` and `Vegetables`
- Each collection has methods like `add()`, `remove()`, `list()`;
- Units have to be stored as grams;
- Store the collections in a storage engine of your choice. (e.g. Database, In-memory)
- Provide an API endpoint to query the collections. As a bonus, this endpoint can accept filters to be applied to the returning collection.
- Provide another API endpoint to add new items to the collections (i.e., your storage engine).
- As a bonus you might:
  - consider giving an option to decide which units are returned (kilograms/grams);
  - how to implement `search()` method collections;
  - use latest version of Symfony's to embed your logic

### ✔️ How can I check if my code is working?

You have two ways of moving on:

- You call the Service from PHPUnit test like it's done in dummy test (just run `bin/phpunit` from the console)

or

- You create a Controller which will be calling the service with a json payload

## 💡 Hints before you start working on it

- Keep KISS, DRY, YAGNI, SOLID principles in mind
- We value a clean domain model, without unnecessary code duplication or complexity
- Think about how you will handle input validation
- Follow generally-accepted good practices, such as no logic in controllers, information hiding (see the first hint).
- Timebox your work - we expect that you would spend between 3 and 4 hours.
- Your code should be tested
- We don't care how you handle data persistence, no bonus points for having a complex method

## When you are finished

- Please upload your code to a public git repository (i.e. GitHub, Gitlab)

## 🐳 Docker image

Optional. Just here if you want to run it isolated.

### 📥 Pulling image

```bash
docker pull tturkowski/fruits-and-vegetables
```

### 🧱 Building image

````bash
docker build -t tturkowski/fruits-and-vegetables -f docker/Dockerfile .```
````

### 🏃‍♂️ Running container

```bash
docker run -it -w/app -v$(pwd):/app tturkowski/fruits-and-vegetables sh
```

### 🛂 Running tests

```bash
docker run -it -w/app -v$(pwd):/app tturkowski/fruits-and-vegetables bin/phpunit
```

### ⌨️ Run development server

```bash
docker run -it -w/app -v$(pwd):/app -p8080:8080 tturkowski/fruits-and-vegetables php -S 0.0.0.0:8080 -t /app/public
# Open http://127.0.0.1:8080 in your browser
```
