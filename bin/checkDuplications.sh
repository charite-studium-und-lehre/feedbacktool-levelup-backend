cd `dirname $0`

tools/phpcpd --exclude=vendor --exclude=var --exclude=tests ..
