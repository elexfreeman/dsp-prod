<?php
/**
 * Created by PhpStorm.
 * User: cod_llo
 * Date: 11.03.16
 * Time: 17:11
 */
/*Модель для работой с Пациентом*/


class Pg_model extends CI_Model
{

    public function __construct()
    {
        date_default_timezone_set('Europe/London');
        $this->load->helper('url');
        $this->db = $this->load->database('pg', TRUE);
        $this->load->library(array('elex'));
    }

    /*- Результат выполнения мероприятия*/
    public function Get_rhb_res()
    {
        /*
        ID    	SERIAL NOT NULL PRIMARY KEY	Ключ
        NAME  	char(1024)	Полное название
        SHNAME	char(64) 	Короткое название
        ARC	date	Дата перевода записи в архив
        UDT	TIMESTAMP with time zone	Метка времени изменения записи
        ADT	TIMESTAMP with time zone	Метка времени скачивания записи

        */

        $query = $this->db->get('rhb_res');
        return $query->result_array();
    }

    public function insert_prg($data)
    {
        /*
        DT    	date    	Дата разработки ИПР (XML: tIPRA-DavelopDate)
        SNILS 	char(15)	ПФР код (XML: tIPRA-Person-SNILS)
        LNAME 	char(30)	Фамилия обладателя ИПР/ПРП (XML: tIPRA-Person-FIO-LastName)
        FNAME 	char(30)	Имя обладателя ИПР/ПРП (XML: tIPRA-Person-FIO-FirstName)
        SNAME 	char(30)	Отчество обладателя ИПР/ПРП (XML: tIPRA-Person-FIO-SecondName)
        BDATE 	date    	Дата рождения обладателя ИПР/ПРП (XML: tIPRA-Person-BirthDate)
        GNDR  	smallint	Пол: 1-муж, 2-жен (XML: tIPRA-Person-IsMale)
        OIVID	int	PRG_OIV.ID Орган исполнительной власти (XML: tIPRA-Recipient-RecipientType-Id)
        DOCNUM	char(20)	Номер протокола (XML: tIPRA-ProtocolNum)
        DOCDT 	date    	Дата протокола проведения МСЭ (XML: tIPRA-ProtocolDate)
        PRG   	smallint	Программа: 1-ИПР, 2-ПРП
        PRGNUM	char(20)	Номер ИПР/ПРП (XML: tIPRA-Number)
        PRGDT 	date    	Дата выдачи ИПР (XML: tIPRA-IssueDate)
        MSEID 	char(36)	Ключ ИПР/ПРП из ФБ МСЭ (XML: tIPRA-Id !!! Обязателен к заполнению)
        UDT	TIMESTAMP with time zone	Метка времени изменения записи
        ADT	TIMESTAMP with time zone	Метка времени скачивания записи
*/
        /*PRG_OKR.ID Код округа*/
        $data['okr_id'] = 4;
        /*PRG_REG.ID Код региона*/
        $data['nreg'] = 63;
        /*программа*/
        $data['prg'] = 1;
        $this->db->insert('prg', $data);
        return $this->db->insert_id();
    }

    /*ИПР/ПРП - реабилитация*/
    public function insert_prg_rhb($data)
    {
        /*
        ID    	SERIAL NOT NULL PRIMARY KEY	Ключ
        PRGID 	int not null	PRG.ID Ключ из таблицы PRG
        TYPEID	int not null	RHB_TYPE.ID Тип мероприятия
        EVNTID	int      	RHB_EVNT.ID Подтип мероприятия
        DICID 	int      	RHB_DIC.ID Мероприятие из справочника
        TSRID 	int      	RHB_TSR.ID Мероприятие из справочника
        NAME  	char(128)	Название мероприятия (если нет в справочнике)
        DT_EXC	date     	Дата выполнения мероприятия
        EXCID 	int      	RHB_EXC.ID Исполнитель мероприятия из справочника
        EXECUT	char(128)	Исполнитель мероприятия (если нет в справочнике)
        RESID 	int      	RHB_RES.ID Результат выполнения мероприятия из справочника
        PAR1	int	Параметр 1 (в резерве)
        PAR2	int	Параметр 2 (в резерве)
        PAR3	int	Параметр 3 (в резерве)
        RESULT	char(128)	Результат выполнения мероприятия (+ Реквизиты контракта)
        NOTE  	char(64) 	Примечание
        UDT	TIMESTAMP with time zone	Метка времени изменения записи
        ADT	TIMESTAMP with time zone	Метка времени скачивания записи
        */

        $this->db->insert('prg_rhb', $data);
        return $this->db->insert_id();
    }

    /*Мероприятия*/
    public function insert_rhb_dic($data)
    {
        /*
            ID    	SERIAL NOT NULL PRIMARY KEY	Ключ
            NAME  	char(1024)	Полное название
            SHNAME	char(64) 	Короткое название
            ARC	date	Дата перевода записи в архив
            UDT	TIMESTAMP with time zone	Метка времени изменения записи
            ADT	TIMESTAMP with time zone	Метка времени скачивания записи
        */

        $data['typeid'] = 2;
        $this->db->insert('rhb_dic', $data);
        return $this->db->insert_id();
    }

    /*Типы мероприятий*/
    public function Get_rhb_type()
    {
        /*
        ID    	SERIAL NOT NULL PRIMARY KEY	Ключ
        GRPID	int not null	RHB_GRP.ID Раздел
        NAME  	char(1024)	Полное название
        SHNAME	char(64) 	Короткое название
        ARC	date	Дата перевода записи в архив
        UDT	TIMESTAMP with time zone	Метка времени изменения записи
        ADT	TIMESTAMP with time zone	Метка времени скачивания записи

        */
        $query = $this->db->get('rhb_type');
        return $query->result_array();
    }

    /*Подтипы мероприятий*/
    public function Get_rhb_evnt($rhb_type_id)
    {
        /*
        ID    	SERIAL NOT NULL PRIMARY KEY	Ключ
        TYPEID	int not null	RHB_TYPE.ID Тип мероприятия
        NAME  	char(1024)	Полное название
        SHNAME	char(64) 	Короткое название
        ARC	date	Дата перевода записи в архив
        UDT	TIMESTAMP with time zone	Метка времени изменения записи
        ADT	TIMESTAMP with time zone	Метка времени скачивания записи
        */
        $query = $this->db->get_where('rhb_evnt', array('typeid' => $rhb_type_id));
        return $query->result_array();
    }

    /*исполнитель*/
    public function Get_rhb_exc($id)
    {
        /*ID    	SERIAL NOT NULL PRIMARY KEY	Ключ
        NAME  	char(1024)	Полное название
        SCODE	char(64) 	Короткое название
        INN	char(10)	ИНН организации
        OGRN	char(15)	ОГРН организации
        ARC	date	Дата перевода записи в архив
        UDT	TIMESTAMP with time zone	Метка времени изменения записи
        ADT	TIMESTAMP with time zone	Метка времени скачивания записи
        */
        $query = $this->db->get_where('rhb_exc', array('id' => $id));
        return $query->result_array();
    }









}
