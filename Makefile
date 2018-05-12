# defines variables
include Make.config

# finds all php files in a given directory
macro_find_phpfiles = $(shell find $(1) -type f -name "*.php")

# finds all php sources in SRCS directories
src = $(foreach d,$(SRCS),$(call macro_find_phpfiles,$(d)))

# run all tests
.PHONY: test
test: install phplint phpspec

.PHONY: list
list:
	@echo ""
	@echo "Useful targets:"
	@echo ""
	@echo "  go           > go to workspace"
	@echo "  up           > Up environment"
	@echo "  stop         > stop"
	@echo "  build        > build"
	@echo "  test         > run phpunit, linter, phpmd, sonar qube (default target)"
	@echo "  phplint      > run php linter (php -l)"
	@echo "  phpspec      > run phpspec"
	@echo ""
	@echo "  install      > install composer dependencies"
	@echo "  deps_update  > explicitly update dependencies (composer update)"
	@echo "  clean        > stop server, clean tmp files and vendor dir"
	@echo "  clean_tmp    > clean temporary files (and stop server)"
	@echo "  clean_vendor > remove vendor dir"
	@echo ""
	@echo "  server_start > start dev server"
	@echo "  server_stop  > stop dev server"

.PHONY: clean
clean: clean_tmp clean_vendor

.PHONY: go
go:
	cd docker; docker-compose exec workspace bash

.PHONY: up
up:
	cd docker; docker-compose up -d nginx mysql;


.PHONY: stop
stop:
	cd docker; docker-compose down;


.PHONY: build
build:
	cd docker; docker-compose down;\
      docker-compose up --build -d nginx mysql;\

.PHONY: clean_tmp
clean_tmp: server_stop
	test ! -e "$(TMP_DIR)" || rm -r "$(TMP_DIR)"

.PHONY: clean_vendor
clean_vendor:
	test ! -e vendor || rm -r vendor

.PHONY: install
install:
    cp -n env-example .env;\
    cp -n docker/env-example docker/.env;\
    cd docker; docker-compose down;\
    docker-compose up -d nginx mysql;\
    docker-compose ps;\
    docker-compose exec workspace composer global require phploc/phploc;\
    docker-compose exec workspace composer global require phpmd/phpmd;\
    docker-compose exec workspace composer global require overtrue/phplint;\
    docker-compose exec workspace composer install;\
    docker-compose exec workspace php artisan migrate;

# task to explicitly update the dependencies
.PHONY: deps_update
deps_update:
	$(COMPOSER_BIN) update

# runs only if a source file has been modified
.PHONY: phpspec
phpspec: $(TMP_DIR)/phpspec

$(TMP_DIR)/phpspec: $(TMP_DIR) vendor/autoload.php phpspec.yml $(src)
	$(PHP_BIN) ./vendor/bin/phpspec run
	touch $@

# lint all modified sources
.PHONY: phplint
phplint: $(TMP_DIR)/phplint

$(TMP_DIR)/phplint: $(TMP_DIR) $(src)
	@echo lint source files...
	@$(foreach f,$(filter-out $(TMP_DIR),$?),$(PHP_BIN) -l $(f);)
	touch $@

# we only do `install`, as composer.json may change
# without wanting to update dependencies.
# Please check the composer warning of out-of-sync
# packages.
composer.lock: composer.json
	$(COMPOSER_BIN) install
	touch $@

# make sure deps get installed even if
# composer.lock exists initially (or
# after `git pull`)
vendor/autoload.php: composer.lock
	$(COMPOSER_BIN) install
	touch $@

.PHONY: server_start
server_start: $(TMP_DIR)/server.PID

.PHONY: server_stop
server_stop:
	test ! -e $(TMP_DIR)/server.PID || { kill `cat $(TMP_DIR)/server.PID`; rm $(TMP_DIR)/server.PID; }

# starts the server, redirect stdout/stderr to log files in TMP_DIR,
# and writes the process id to the target file
# Note: If TMP_DIR does not yet exist, we create it manually instead
# of declaring a dependency of it. The reason is that we don't want
# to run this rule if the server is already started, but the TMP_DIR's
# timestamp has been modified
$(TMP_DIR)/server.PID:
	mkdir -p $(TMP_DIR)
	$(PHP_BIN) -S $(DEV_SERVER_ADDR) -t $(PUBLIC_DIR) >$(TMP_DIR)/server.log 2>$(TMP_DIR)/server.err.log & echo $$! > $@;

$(TMP_DIR):
	mkdir -p $@