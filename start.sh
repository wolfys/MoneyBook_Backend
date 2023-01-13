
echo -n "\n\033[31m-------------------------------- \033[39m \n"
echo -n "Выберите нужную команду: \n\n"
echo -n "1: \033[31m php artisan optimize \033[39m - очистить кэш \n"
echo -n "2: \033[31m php artisan migrate:fresh --seed \033[39m - уничтожить таблицы и создать заново\n"
echo -n "3: \033[31m php artisan route:list  \033[39m - получить список всех роутеров\n"
echo -n "4: \033[31m php artisan scribe:generate \033[39m - сгенерировать документацию\n"
echo -n "5: \033[31m php artisan test \033[39m - запустить тесты\n"
echo -n "6: \033[31m git pull origin master \033[39m - слить данные с git\n"
echo -n "7: \033[31m clear \033[39m - очистить консоль\n"
echo -n "\033[31m-------------------------------- \033[39m \n\n"
read ID
echo -n "\033[102m Выполнение \033[49m \n"
case $ID in

	1)
	php artisan optimize
	;;

	2)
	php artisan migrate:fresh --seed
	;;

	3)
	php artisan route:list
	;;

	4)
	php artisan scribe:generate
	;;

    5)
    php artisan test
    ;;

    6)
    git pull origin master
    ;;

	7)
	clear
	;;
esac
echo -n "\033[101m Завершено \033[49m \n"
sh start.sh
