# Composer

- I ran a `composer update` as I had some compatibiliry warnings when running Composer

# CI/CD

# Dockerfile

- I bumped alpine to 3.21, but I don't advocate for doing it mindlessly, the service should be safeguarded by tests to catch regressions. I had cases in the past where this was an issue (but on not ideal software, as there were hardcoded library dependencies)

- I am not familiar with mlocati's script, so I decided to make a vanilla install

# Structure

- I usually like to have a folded dedicated to the infrastructural stuff (usually Dockerfiles, NGINX configs, etc. - I've also put there Terraform .tfvars, ...)

# Makefile

- I usually like to have a `Makefile` for the main operations. It's easy to set up and the targets have autocompletion

# TODOs

Things I didn't implement for sake of simplicity or time constraints but would be nice to have:

- Use proper DTOs for request and response payloads
- solve permission issues (use correct user in Docker)
- JWT authentication for API calls
-
- OpenAPI bundle and definitions
- proper logging
  - Symgony logging levels (debug, info, ...)
  - Different log channels and env configs
  - Symfony JSON log (for Logstash etc.)
  - better Nginx log
- etc.
- etc. :)

Things that could have made sense only in a more complex scenario:

- correlation ids
- throttling
- batching inserts
