-- Список ИПР и ПРП
drop table if exists PRG;
create table PRG(
  ID         SERIAL NOT NULL PRIMARY KEY       ,-- Ключ
  OKR_ID     smallint    ,-- PRG_OKR.ID Код округа
  NREG       smallint    ,-- PRG_REG.ID Код региона
  DT         date        ,-- Дата разработки ИПР (XML: tIPRA-DavelopDate)

  SNILS      char(15)    ,-- ПФР код (XML: tIPRA-Person-SNILS)
  LNAME      char(30)    ,-- Фамилия обладателя ИПР/ПРП (XML: tIPRA-Person-FIO-LastName)
  FNAME      char(30)    ,-- Имя обладателя ИПР/ПРП (XML: tIPRA-Person-FIO-FirstName)
  SNAME      char(30)    ,-- Отчество обладателя ИПР/ПРП (XML: tIPRA-Person-FIO-SecondName)
  BDATE      date        ,-- Дата рождения обладателя ИПР/ПРП (XML: tIPRA-Person-BirthDate)
  GNDR       smallint    ,-- Пол: 1-муж, 2-жен (XML: tIPRA-Person-IsMale)
  OIVID      int         ,-- PRG_OIV.ID Орган исполнительной власти (XML: tIPRA-Recipient-RecipientType-Id)
  DOCNUM     char(20)    ,-- Номер протокола (XML: tIPRA-ProtocolNum)
  DOCDT      date        ,-- Дата протокола проведения МСЭ (XML: tIPRA-ProtocolDate)
  PRG        smallint    ,-- Программа: 1-ИПР, 2-ПРП
  PRGNUM     char(20)    ,-- Номер ИПР/ПРП (XML: tIPRA-Number)
  PRGDT      date        ,-- Дата выдачи ИПР (XML: tIPRA-IssueDate)
  MSEID      char(36)    ,-- Ключ ИПР/ПРП из ФБ МСЭ (XML: tIPRA-Id !!! Обязателен к заполнению)
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN PRG.ID     IS 'Ключ';
COMMENT ON COLUMN PRG.OKR_ID IS 'PRG_OKR.ID Код округа';
COMMENT ON COLUMN PRG.NREG   IS 'PRG_REG.ID Код региона';
COMMENT ON COLUMN PRG.DT     IS 'Дата разработки ИПР (XML: tIPRA-DavelopDate)';
COMMENT ON COLUMN PRG.SNILS  IS 'ПФР код (XML: tIPRA-Person-SNILS)';
COMMENT ON COLUMN PRG.LNAME  IS 'Фамилия обладателя ИПР/ПРП (XML: tIPRA-Person-FIO-LastName)';
COMMENT ON COLUMN PRG.FNAME  IS 'Имя обладателя ИПР/ПРП (XML: tIPRA-Person-FIO-FirstName)';
COMMENT ON COLUMN PRG.SNAME  IS 'Отчество обладателя ИПР/ПРП (XML: tIPRA-Person-FIO-SecondName)';
COMMENT ON COLUMN PRG.BDATE  IS 'Дата рождения обладателя ИПР/ПРП (XML: tIPRA-Person-BirthDate)';
COMMENT ON COLUMN PRG.GNDR   IS 'Пол: 1-муж, 2-жен (XML: tIPRA-Person-IsMale)';
COMMENT ON COLUMN PRG.OIVID  IS 'PRG_OIV.ID Орган исполнительной власти (XML: tIPRA-Recipient-RecipientType-Id)';
COMMENT ON COLUMN PRG.DOCNUM IS 'Номер протокола (XML: tIPRA-ProtocolNum)';
COMMENT ON COLUMN PRG.DOCDT  IS 'Дата протокола проведения МСЭ (XML: tIPRA-ProtocolDate)';
COMMENT ON COLUMN PRG.PRG    IS 'Программа: 1-ИПР, 2-ПРП';
COMMENT ON COLUMN PRG.PRGNUM IS 'Номер ИПР/ПРП (XML: tIPRA-Number)';
COMMENT ON COLUMN PRG.PRGDT  IS 'Дата выдачи ИПР (XML: tIPRA-IssueDate)';
COMMENT ON COLUMN PRG.MSEID  IS 'Ключ ИПР/ПРП из ФБ МСЭ (XML: tIPRA-Id !!! Обязателен к заполнению)';
COMMENT ON COLUMN PRG.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN PRG.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX prg_udt ON PRG (UDT);

-- ИПР/ПРП - реабилитация
drop table if exists PRG_RHB;
create table PRG_RHB(
  ID         SERIAL NOT NULL PRIMARY KEY       ,-- Ключ
  PRGID      int not null,-- PRG.ID Ключ из таблицы PRG
  TYPEID     int not null,-- RHB_TYPE.ID Тип мероприятия
  EVNTID     int         ,-- RHB_EVNT.ID Подтип мероприятия
  DICID      int         ,-- RHB_DIC.ID Мероприятие из справочника
  TSRID      int         ,-- RHB_TSR.ID ТСР из справочника
  NAME       char(128)   ,-- Название мероприятия (если нет в справочнике)
  DT_EXC     date        ,-- Дата выполнения мероприятия
  EXCID      int         ,-- RHB_EXC.ID Исполнитель мероприятия из справочника
  EXECUT     char(128)   ,-- Исполнитель мероприятия (если нет в справочнике)
  RESID      int         ,-- RHB_RES.ID Результат выполнения мероприятия из справочника
  PAR1       int         ,-- Параметр 1 (в резерве)
  PAR2       int         ,-- Параметр 2 (в резерве)
  PAR3       int         ,-- Параметр 3 (в резерве)
  RESULT     char(128)   ,-- Результат выполнения мероприятия (+ Реквизиты контракта)
  NOTE       char(64)    ,-- Примечание
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN PRG_RHB.ID     IS 'Ключ';
COMMENT ON COLUMN PRG_RHB.PRGID  IS 'PRG.ID Ключ из таблицы PRG';
COMMENT ON COLUMN PRG_RHB.TYPEID IS 'RHB_TYPE.ID Тип мероприятия';
COMMENT ON COLUMN PRG_RHB.EVNTID IS 'RHB_EVNT.ID Подтип мероприятия';
COMMENT ON COLUMN PRG_RHB.DICID  IS 'RHB_DIC.ID Мероприятие из справочника';
COMMENT ON COLUMN PRG_RHB.TSRID  IS 'RHB_TSR.ID ТСР из справочника';
COMMENT ON COLUMN PRG_RHB.NAME   IS 'Название мероприятия (если нет в справочнике)';
COMMENT ON COLUMN PRG_RHB.DT_EXC IS 'Дата выполнения мероприятия';
COMMENT ON COLUMN PRG_RHB.EXCID  IS 'RHB_EXC.ID Исполнитель мероприятия из справочника';
COMMENT ON COLUMN PRG_RHB.EXECUT IS 'Исполнитель мероприятия (если нет в справочнике)';
COMMENT ON COLUMN PRG_RHB.RESID  IS 'RHB_RES.ID Результат выполнения мероприятия из справочника';
COMMENT ON COLUMN PRG_RHB.PAR1   IS 'Параметр 1 (в резерве)';
COMMENT ON COLUMN PRG_RHB.PAR2   IS 'Параметр 2 (в резерве)';
COMMENT ON COLUMN PRG_RHB.PAR3   IS 'Параметр 3 (в резерве)';
COMMENT ON COLUMN PRG_RHB.RESULT IS 'Результат выполнения мероприятия (+ Реквизиты контракта)';
COMMENT ON COLUMN PRG_RHB.NOTE   IS 'Примечание';
COMMENT ON COLUMN PRG_RHB.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN PRG_RHB.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX prg_rhb_udt ON PRG_RHB (UDT);

-- Справочники

-- Справочник округов
drop table if exists PRG_OKR;
create table PRG_OKR(
  ID         SERIAL NOT NULL PRIMARY KEY       ,-- Ключ
  NAME       char(1024)  ,-- Полное название
  SHNAME     char(64)    ,-- Короткое название
  ARC        date        ,-- Дата перевода записи в архив
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN PRG_OKR.ID     IS 'Ключ';
COMMENT ON COLUMN PRG_OKR.NAME   IS 'Полное название';
COMMENT ON COLUMN PRG_OKR.SHNAME IS 'Короткое название';
COMMENT ON COLUMN PRG_OKR.ARC    IS 'Дата перевода записи в архив';
COMMENT ON COLUMN PRG_OKR.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN PRG_OKR.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX prg_okr_udt ON PRG_OKR (UDT);

-- Справочник регионов
drop table if exists PRG_REG;
create table PRG_REG(
  ID         SERIAL NOT NULL PRIMARY KEY       ,-- Ключ
  OKR_ID     int not null,-- PRG_OKR.ID Округ
  NAME       char(1024)  ,-- Полное название
  SHNAME     char(64)    ,-- Короткое название
  ARC        date        ,-- Дата перевода записи в архив
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN PRG_REG.ID     IS 'Ключ';
COMMENT ON COLUMN PRG_REG.OKR_ID IS 'PRG_OKR.ID Округ';
COMMENT ON COLUMN PRG_REG.NAME   IS 'Полное название';
COMMENT ON COLUMN PRG_REG.SHNAME IS 'Короткое название';
COMMENT ON COLUMN PRG_REG.ARC    IS 'Дата перевода записи в архив';
COMMENT ON COLUMN PRG_REG.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN PRG_REG.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX prg_reg_udt ON PRG_REG (UDT);

-- Список органов исполнительной власти РФ (ведомств)
drop table if exists PRG_OIV;
create table PRG_OIV(
  ID         SERIAL NOT NULL PRIMARY KEY       ,-- Ключ
  NAME       char(1024)  ,-- Полное название
  SHNAME     char(64)    ,-- Короткое название
  ARC        date        ,-- Дата перевода записи в архив
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN PRG_OIV.ID     IS 'Ключ';
COMMENT ON COLUMN PRG_OIV.NAME   IS 'Полное название';
COMMENT ON COLUMN PRG_OIV.SHNAME IS 'Короткое название';
COMMENT ON COLUMN PRG_OIV.ARC    IS 'Дата перевода записи в архив';
COMMENT ON COLUMN PRG_OIV.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN PRG_OIV.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX prg_oiv_udt ON PRG_OIV (UDT);

-- Список разделов
drop table if exists RHB_GRP;
create table RHB_GRP(
  ID         SERIAL NOT NULL PRIMARY KEY       ,-- Ключ
  NAME       char(1024)  ,-- Полное название
  SHNAME     char(64)    ,-- Короткое название
  ARC        date        ,-- Дата перевода записи в архив
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN RHB_GRP.ID     IS 'Ключ';
COMMENT ON COLUMN RHB_GRP.NAME   IS 'Полное название';
COMMENT ON COLUMN RHB_GRP.SHNAME IS 'Короткое название';
COMMENT ON COLUMN RHB_GRP.ARC    IS 'Дата перевода записи в архив';
COMMENT ON COLUMN RHB_GRP.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN RHB_GRP.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX rhb_grp_udt ON RHB_GRP (UDT);

-- Типы мероприятий
drop table if exists RHB_TYPE;
create table RHB_TYPE(
  ID         SERIAL NOT NULL PRIMARY KEY       ,-- Ключ
  GRPID      int not null,-- RHB_GRP.ID Раздел
  NAME       char(1024)  ,-- Полное название
  SHNAME     char(64)    ,-- Короткое название
  ARC        date        ,-- Дата перевода записи в архив
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN RHB_TYPE.ID     IS 'Ключ';
COMMENT ON COLUMN RHB_TYPE.GRPID  IS 'RHB_GRP.ID Раздел';
COMMENT ON COLUMN RHB_TYPE.NAME   IS 'Полное название';
COMMENT ON COLUMN RHB_TYPE.SHNAME IS 'Короткое название';
COMMENT ON COLUMN RHB_TYPE.ARC    IS 'Дата перевода записи в архив';
COMMENT ON COLUMN RHB_TYPE.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN RHB_TYPE.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX rhb_type_udt ON RHB_TYPE (UDT);

-- Подтипы мероприятий
drop table if exists RHB_EVNT;
create table RHB_EVNT(
  ID         SERIAL NOT NULL PRIMARY KEY       ,-- Ключ
  TYPEID     int not null,-- RHB_TYPE.ID Тип мероприятия
  NAME       char(1024)  ,-- Полное название
  SHNAME     char(64)    ,-- Короткое название
  ARC        date        ,-- Дата перевода записи в архив
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN RHB_EVNT.ID     IS 'Ключ';
COMMENT ON COLUMN RHB_EVNT.TYPEID IS 'RHB_TYPE.ID Тип мероприятия';
COMMENT ON COLUMN RHB_EVNT.NAME   IS 'Полное название';
COMMENT ON COLUMN RHB_EVNT.SHNAME IS 'Короткое название';
COMMENT ON COLUMN RHB_EVNT.ARC    IS 'Дата перевода записи в архив';
COMMENT ON COLUMN RHB_EVNT.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN RHB_EVNT.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX rhb_evnt_udt ON RHB_EVNT (UDT);

-- Мероприятия
drop table if exists RHB_DIC;
create table RHB_DIC(
  ID         SERIAL NOT NULL PRIMARY KEY       ,-- Ключ
  NAME       char(1024)  ,-- Полное название
  SHNAME     char(64)    ,-- Короткое название
  ARC        date        ,-- Дата перевода записи в архив
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN RHB_DIC.ID     IS 'Ключ';
COMMENT ON COLUMN RHB_DIC.NAME   IS 'Полное название';
COMMENT ON COLUMN RHB_DIC.SHNAME IS 'Короткое название';
COMMENT ON COLUMN RHB_DIC.ARC    IS 'Дата перевода записи в архив';
COMMENT ON COLUMN RHB_DIC.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN RHB_DIC.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX rhb_dic_udt ON RHB_DIC (UDT);

-- Справочник групп ТСР
drop table if exists RHB_GTSR;
create table RHB_GTSR(
  ID         SERIAL NOT NULL PRIMARY KEY       ,-- Ключ
  NAME       char(1024)  ,-- Полное название
  SCODE      char(20)    ,-- Короткое название
  ARC        date        ,-- Дата перевода записи в архив
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN RHB_GTSR.ID     IS 'Ключ';
COMMENT ON COLUMN RHB_GTSR.NAME   IS 'Полное название';
COMMENT ON COLUMN RHB_GTSR.SCODE  IS 'Короткое название';
COMMENT ON COLUMN RHB_GTSR.ARC    IS 'Дата перевода записи в архив';
COMMENT ON COLUMN RHB_GTSR.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN RHB_GTSR.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX rhb_gtsr_udt ON RHB_GTSR (UDT);

-- Справочник ТСР
drop table if exists RHB_TSR;
create table RHB_TSR(
  ID         SERIAL NOT NULL PRIMARY KEY       ,-- Ключ
  GTSRID     int not null,-- RHB_GTSR.ID группа ТСР
  NAME       char(1024)  ,-- Полное название
  SCODE      char(20)    ,-- Короткое название
  ARC        date        ,-- Дата перевода записи в архив
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN RHB_TSR.ID     IS 'Ключ';
COMMENT ON COLUMN RHB_TSR.GTSRID IS 'RHB_GTSR.ID группа ТСР';
COMMENT ON COLUMN RHB_TSR.NAME   IS 'Полное название';
COMMENT ON COLUMN RHB_TSR.SCODE  IS 'Короткое название';
COMMENT ON COLUMN RHB_TSR.ARC    IS 'Дата перевода записи в архив';
COMMENT ON COLUMN RHB_TSR.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN RHB_TSR.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX rhb_tsr_udt ON RHB_TSR (UDT);

-- Организации исполнители мероприятий
drop table if exists RHB_EXC;
create table RHB_EXC(
  ID         SERIAL NOT NULL PRIMARY KEY       ,-- Ключ
  NAME       char(1024)  ,-- Полное название
  SCODE      char(64)    ,-- Короткое название
  INN        char(10)    ,-- ИНН организации
  OGRN       char(15)    ,-- ОГРН организации
  ARC        date        ,-- Дата перевода записи в архив
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN RHB_EXC.ID     IS 'Ключ';
COMMENT ON COLUMN RHB_EXC.NAME   IS 'Полное название';
COMMENT ON COLUMN RHB_EXC.SCODE  IS 'Короткое название';
COMMENT ON COLUMN RHB_EXC.INN    IS 'ИНН организации';
COMMENT ON COLUMN RHB_EXC.OGRN   IS 'ОГРН организации';
COMMENT ON COLUMN RHB_EXC.ARC    IS 'Дата перевода записи в архив';
COMMENT ON COLUMN RHB_EXC.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN RHB_EXC.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX rhb_exc_udt ON RHB_EXC (UDT);

-- Результат выполнения мероприятия
drop table if exists RHB_RES;
create table RHB_RES(
  ID         SERIAL NOT NULL PRIMARY KEY     ,-- Ключ
  NAME       char(1024)  ,-- Полное название
  SHNAME     char(64)    ,-- Короткое название
  ARC        date        ,-- Дата перевода записи в архив
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN RHB_RES.ID     IS 'Ключ';
COMMENT ON COLUMN RHB_RES.NAME   IS 'Полное название';
COMMENT ON COLUMN RHB_RES.SHNAME IS 'Короткое название';
COMMENT ON COLUMN RHB_RES.ARC    IS 'Дата перевода записи в архив';
COMMENT ON COLUMN RHB_RES.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN RHB_RES.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX rhb_res_udt ON RHB_RES (UDT);

-- Служебные таблицы

-- Контроль версий
drop table if exists APP_VER;
create table APP_VER(
  ID         SERIAL NOT NULL PRIMARY KEY     ,-- Ключ
  NAME       char(30)   ,-- Название
  VERS       char(5)    ,-- Версия
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN APP_VER.ID     IS 'Ключ';
COMMENT ON COLUMN APP_VER.NAME   IS 'Полное название';
COMMENT ON COLUMN APP_VER.VERS   IS 'Версия';
COMMENT ON COLUMN APP_VER.UDT    IS 'Метка времени изменения записи';
COMMENT ON COLUMN APP_VER.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX app_ver_udt ON APP_VER (UDT);

-- Таблица удаленных записей.
drop table if exists DEL_LOG;
create table DEL_LOG (
  ID         SERIAL NOT NULL PRIMARY KEY ,-- Ключ
  T_NAME     name not null               ,-- Название таблицы
  T_ID       int not null                ,-- ID в таблице
  UDT        TIMESTAMP with time zone DEFAULT CURRENT_TIMESTAMP     ,-- Метка времени изменения записи
  ADT        TIMESTAMP with time zone DEFAULT '-infinity'            -- Метка времени скачивания записи
);
COMMENT ON COLUMN DEL_LOG.ID     IS 'Ключ';
COMMENT ON COLUMN DEL_LOG.T_NAME IS 'Название таблицы';
COMMENT ON COLUMN DEL_LOG.T_ID 	 IS 'ID в таблице';
COMMENT ON COLUMN DEL_LOG.UDT 	 IS 'Метка времени изменения записи';
COMMENT ON COLUMN DEL_LOG.ADT    IS 'Метка времени скачивания записи';
CREATE INDEX del_log_udt ON DEL_LOG (UDT);

-- Создание триггерных функций
/*
-- APP_VER
DROP TRIGGER IF EXISTS udt_bi ON APP_VER;
DROP TRIGGER IF EXISTS udt_bu ON APP_VER;
DROP TRIGGER IF EXISTS log_ad ON APP_VER;
-- PRG
DROP TRIGGER IF EXISTS udt_bi ON PRG;
DROP TRIGGER IF EXISTS udt_bu ON PRG;
DROP TRIGGER IF EXISTS log_ad ON PRG;
DROP TRIGGER IF EXISTS touch_prg_rhb_au ON PRG;
-- PRG_RHB
DROP TRIGGER IF EXISTS udt_bi ON PRG_RHB;
DROP TRIGGER IF EXISTS udt_bu ON PRG_RHB;
DROP TRIGGER IF EXISTS log_ad ON PRG_RHB;
-- PRG_OKR
DROP TRIGGER IF EXISTS udt_bi ON PRG_OKR;
DROP TRIGGER IF EXISTS udt_bu ON PRG_OKR;
DROP TRIGGER IF EXISTS log_ad ON PRG_OKR;
-- PRG_REG
DROP TRIGGER IF EXISTS udt_bi ON PRG_REG;
DROP TRIGGER IF EXISTS udt_bu ON PRG_REG;
DROP TRIGGER IF EXISTS log_ad ON PRG_REG;
-- PRG_OIV
DROP TRIGGER IF EXISTS udt_bi ON PRG_OIV;
DROP TRIGGER IF EXISTS udt_bu ON PRG_OIV;
DROP TRIGGER IF EXISTS log_ad ON PRG_OIV;
-- RHB_GRP
DROP TRIGGER IF EXISTS udt_bi ON RHB_GRP;
DROP TRIGGER IF EXISTS udt_bu ON RHB_GRP;
DROP TRIGGER IF EXISTS log_ad ON RHB_GRP;
-- RHB_TYPE
DROP TRIGGER IF EXISTS udt_bi ON RHB_TYPE;
DROP TRIGGER IF EXISTS udt_bu ON RHB_TYPE;
DROP TRIGGER IF EXISTS log_ad ON RHB_TYPE;
-- RHB_EVNT
DROP TRIGGER IF EXISTS udt_bi ON RHB_EVNT;
DROP TRIGGER IF EXISTS udt_bu ON RHB_EVNT;
DROP TRIGGER IF EXISTS log_ad ON RHB_EVNT;
-- RHB_DIC
DROP TRIGGER IF EXISTS udt_bi ON RHB_DIC;
DROP TRIGGER IF EXISTS udt_bu ON RHB_DIC;
DROP TRIGGER IF EXISTS log_ad ON RHB_DIC;
-- RHB_GTSR
DROP TRIGGER IF EXISTS udt_bi ON RHB_GTSR;
DROP TRIGGER IF EXISTS udt_bu ON RHB_GTSR;
DROP TRIGGER IF EXISTS log_ad ON RHB_GTSR;
-- RHB_TSR
DROP TRIGGER IF EXISTS udt_bi ON RHB_TSR;
DROP TRIGGER IF EXISTS udt_bu ON RHB_TSR;
DROP TRIGGER IF EXISTS log_ad ON RHB_TSR;
-- RHB_EXC
DROP TRIGGER IF EXISTS udt_bi ON RHB_EXC;
DROP TRIGGER IF EXISTS udt_bu ON RHB_EXC;
DROP TRIGGER IF EXISTS log_ad ON RHB_EXC;
-- RHB_RES
DROP TRIGGER IF EXISTS udt_bi ON RHB_RES;
DROP TRIGGER IF EXISTS udt_bu ON RHB_RES;
DROP TRIGGER IF EXISTS log_ad ON RHB_RES;
-- DEL_LOG
DROP TRIGGER IF EXISTS udt_bi ON DEL_LOG;
DROP TRIGGER IF EXISTS udt_bu ON DEL_LOG;
*/
-- Метка времени на insert
--DROP FUNCTION IF EXISTS trigger_udt_before ();

DROP FUNCTION IF EXISTS trigger_udt_before_ins ();
CREATE FUNCTION trigger_udt_before_ins () RETURNS trigger AS $$ 
BEGIN 
NEW.UDT = CURRENT_TIMESTAMP;
return NEW;
END; 
$$ LANGUAGE  plpgsql;
-- Метка времени на update
DROP FUNCTION IF EXISTS trigger_udt_before_upd ();
CREATE FUNCTION trigger_udt_before_upd () RETURNS trigger AS $$ 
BEGIN 
NEW.UDT = CASE WHEN OLD.ADT = NEW.ADT THEN CURRENT_TIMESTAMP ELSE OLD.UDT END;
return NEW;
END; 
$$ LANGUAGE  plpgsql;
-- Лог удаленных записей
DROP FUNCTION IF EXISTS trigger_log_after_del ();
CREATE FUNCTION trigger_log_after_del () RETURNS trigger AS $$ 
BEGIN 
insert into DEL_LOG(T_NAME,T_ID) values (TG_RELNAME,OLD.ID);
return OLD;
END; 
$$ LANGUAGE  plpgsql;
-- Коррекция записей в PRG_RHB после правки PRG
DROP function if exists trigger_touch_prg_rhb_au();
CREATE FUNCTION trigger_touch_prg_rhb_au() RETURNS  trigger AS $$
BEGIN
update prg_rhb set udt=CURRENT_TIMESTAMP where prgid=OLD.id;
return OLD ;
END;
$$ LANGUAGE plpgsql;

-- Создание тригеров метки времени
--APP_VER
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON APP_VER FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON APP_VER FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON APP_VER FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--PRG
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON PRG FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON PRG FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON PRG FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();
-- Создание триггера коррекции
CREATE TRIGGER touch_prg_rhb_au
AFTER UPDATE ON PRG FOR EACH ROW
EXECUTE PROCEDURE trigger_touch_prg_rhb_au(); 

--PRG_RHB
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON PRG_RHB FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON PRG_RHB FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON PRG_RHB FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--PRG_OKR
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON PRG_OKR FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON PRG_OKR FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON PRG_OKR FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--PRG_REG
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON PRG_REG FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON PRG_REG FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON PRG_REG FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--PRG_OIV
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON PRG_OIV FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON PRG_OIV FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON PRG_OIV FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--RHB_GRP
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON RHB_GRP FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON RHB_GRP FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON RHB_GRP FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--RHB_TYPE
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON RHB_TYPE FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON RHB_TYPE FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON RHB_TYPE FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--RHB_EVNT
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON RHB_EVNT FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON RHB_EVNT FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON RHB_EVNT FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--RHB_DIC
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON RHB_DIC FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON RHB_DIC FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON RHB_DIC FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--RHB_GTSR
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON RHB_GTSR FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON RHB_GTSR FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON RHB_GTSR FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--RHB_TSR
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON RHB_TSR FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON RHB_TSR FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON RHB_TSR FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--RHB_EXC
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON RHB_EXC FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON RHB_EXC FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON RHB_EXC FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--RHB_RES
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON RHB_RES FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON RHB_RES FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();
-- Создание триггера DELETE
CREATE TRIGGER log_ad 
AFTER DELETE ON RHB_RES FOR EACH ROW 
EXECUTE PROCEDURE trigger_log_after_del();

--DEL_LOG
-- Создание триггера INSERT
CREATE TRIGGER udt_bi 
BEFORE INSERT ON DEL_LOG FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_ins();
-- Создание триггера UPDATE
CREATE TRIGGER udt_bu 
BEFORE UPDATE ON DEL_LOG FOR EACH ROW 
EXECUTE PROCEDURE trigger_udt_before_upd();

delete from PRG_OKR;
insert into PRG_OKR (ID,SHNAME,NAME,ARC) values
(1,'ЦФО','Центральный Федеральный округ',NULL),
(2,'СЗО','Северо-Западный Федеральный округ',NULL),
(3,'ЮФО','Южный Федеральный округ',NULL),
(4,'ПФО','Приволжский Федеральный округ',NULL),
(5,'УФО','Уральский Федеральный округ',NULL),
(6,'СФД','Сибирский Федеральный округ',NULL),
(7,'ДФО','Дальневосточный Федеральный округ',NULL),
(8,'СКФО','Северо-Кавказский Федеральный округ',NULL),
(9,'КФО','Крымский Федеральный округ','2016-07-28')
;
-- select * from PRG_OKR where arc is null;

delete from PRG_REG;
insert into PRG_REG (ID,OKR_ID,NAME,ARC) values
(1,3,'Республика Адыгея',NULL),
(2,4,'Республика Башкортостан',NULL),
(3,6,'Республика Бурятия',NULL),
(4,6,'Республика Алтай',NULL),
(5,8,'Республика Дагестан',NULL),
(6,8,'Республика Ингушетия',NULL),
(7,8,'Кабардино-Балкарская Республика',NULL),
(8,3,'Республика Калмыкия',NULL),
(9,8,'Карачаево-Черкесская Республика',NULL),
(10,2,'Республика Карелия',NULL),
(11,2,'Республика Коми',NULL),
(12,4,'Республика Марий Эл',NULL),
(13,4,'Республика Мордовия',NULL),
(14,7,'Республика Саха (Якутия)',NULL),
(15,8,'Республика Северная Осетия-Алания',NULL),
(16,4,'Республика Татарстан',NULL),
(17,6,'Республика Тыва',NULL),
(18,4,'Удмуртская Республика',NULL),
(19,6,'Республика Хакасия',NULL),
(20,8,'Чеченская Республика',NULL),
(21,4,'Чувашская Республика',NULL),
(22,6,'Алтайский край',NULL),
(23,3,'Краснодарский край',NULL),
(24,6,'Красноярский край',NULL),
(25,7,'Приморский край',NULL),
(26,8,'Ставропольский край',NULL),
(27,7,'Хабаровский край',NULL),
(28,7,'Амурская область',NULL),
(29,2,'Архангельская область',NULL),
(30,3,'Астраханская область',NULL),
(31,1,'Белгородская область',NULL),
(32,1,'Брянская область',NULL),
(33,1,'Владимирская область',NULL),
(34,3,'Волгоградская область',NULL),
(35,2,'Вологодская область',NULL),
(36,1,'Воронежская область',NULL),
(37,1,'Ивановская область',NULL),
(38,6,'Иркутская область',NULL),
(39,2,'Калининградская область',NULL),
(40,1,'Калужская область',NULL),
(41,7,'Камчатский край',NULL),
(42,6,'Кемеровская область',NULL),
(43,4,'Кировская область',NULL),
(44,1,'Костромская область',NULL),
(45,5,'Курганская область',NULL),
(46,1,'Курская область',NULL),
(47,2,'Ленинградская область',NULL),
(48,1,'Липецкая область',NULL),
(49,7,'Магаданская область',NULL),
(50,1,'Московская область',NULL),
(51,2,'Мурманская область',NULL),
(52,4,'Нижегородская область',NULL),
(53,2,'Новгородская область',NULL),
(54,6,'Новосибирская область',NULL),
(55,6,'Омская область',NULL),
(56,4,'Оренбургская область',NULL),
(57,1,'Орловская область',NULL),
(58,4,'Пензенская область',NULL),
(59,4,'Пермский край',NULL),
(60,2,'Псковская область',NULL),
(61,3,'Ростовская область',NULL),
(62,1,'Рязанская область',NULL),
(63,4,'Самарская область',NULL),
(64,4,'Саратовская область',NULL),
(65,7,'Сахалинская область',NULL),
(66,5,'Свердловская область',NULL),
(67,1,'Смоленская область',NULL),
(68,1,'Тамбовская область',NULL),
(69,1,'Тверская область',NULL),
(70,6,'Томская область',NULL),
(71,1,'Тульская область',NULL),
(72,5,'Тюменская область',NULL),
(73,4,'Ульяновская область',NULL),
(74,5,'Челябинская область',NULL),
(75,6,'Забайкальский край',NULL),
(76,1,'Ярославская область',NULL),
(77,1,'г. Москва',NULL),
(78,2,'г. Санкт-Петербург',NULL),
(79,7,'Еврейская автономная область',NULL),
(80,6,'Агинский Бурятский автономный округ','2008-03-01'),
(81,4,'Коми-Пермяцкий автономный округ','2005-12-01'),
(82,7,'Корякский автономный округ','2007-07-01'),
(83,2,'Ненецкий автономный округ',NULL),
(84,6,'Таймырский автономный округ','2007-01-01'),
(85,6,'Усть-Ордынский Бурятский автономный округ',NULL),
(86,5,'Ханты-Мансийский автономный округ',NULL),
(87,7,'Чукотский автономный округ',NULL),
(88,6,'Эвенкийский автономный округ','2007-01-01'),
(89,5,'Ямало-Ненецкий автономный округ',NULL),
(90,0,'г.Байконур',NULL),
(91,3,'Республика Крым',NULL),
(92,3,'г. Севастопль',NULL)
;
-- select * from PRG_REG;

delete from PRG_OIV;
insert into PRG_OIV (ID,SHNAME,NAME) values
(1,'СОЗ','Сфера охраны здоровья'),
(2,'ОСЗН','Область содействия занятости населения'),
(3,'СО','Сфера образования'),
(4,'ССЗН','Сфера социальной защиты населения'),
(5,'СФКС','Сфера физической культуры и спорта'),
(6,'ФСС РФ','Фонд социального страхования Российской Федерации'),
(7,'ПФР','Пенсионный Фонд Российской Федерации'),
(8,'УФСИН','Управление Федеральной службы исполнения наказания'),
(9,'СУ','Стационарные учреждения')
;
-- select * from PRG_OIV;

delete from RHB_GRP;
insert into RHB_GRP (ID,SHNAME,NAME) values
(1,'первый','Данные об исполнении мероприятий, возложенных ИПРА инвалида (ИПРА ребенка-инвалида) на органы исполнительной власти субъекта Российской Федерации в сфере охраны здоровья'),
(2,'второй','Данные об исполнении мероприятий, возложенных ИПРА инвалида (ИПРА ребенка-инвалида) на органы исполнительной власти субъекта Российской Федерации в области содействия занятости населения'),
(3,'третий','Данные об исполнении мероприятий, возложенных ИПРА инвалида (ИПРА ребенка-инвалида) на органы исполнительной власти субъекта Российской Федерации в сфере образования'),
(4,'четвертый','Данные об исполнении мероприятий, возложенных ИПРА инвалида (ИПРА ребенка-инвалида) на органы исполнительной власти субъекта Российской Федерации в сфере социальной защиты населения'),
(5,'пятый','Данные об исполнении мероприятий, возложенных ИПРА инвалида (ИПРА ребенка-инвалида) на органы исполнительной власти субъекта Российской Федерации в сфере физической культуры и спорта'),
(6,'шестой','Данные об исполнении мероприятий, возложенных ИПРА инвалида (ИПРА ребенка-инвалида) на органы исполнительной власти субъекта Российской Федерации в сфере социальной защиты населения по обеспечению техническими средствами реабилитации (далее-ТСР) и услугами по реабилитации, предоставляемыми инвалиду (ребенку инвалиду) за счет средств федерального бюджета в случае передачи в установленном порядке полномочий российской Федерации по предоставлению ТСР инвалидам субъектам Российской федерации'),
(7,'седьмой','Данные об исполнении мероприятий, возложенных ИПРА инвалида (ИПРА ребенка-инвалида) на органы исполнительной власти субъекта Российской Федерации в сфере социальной защиты населения по обеспечению ТСР и услугами по реабилитации, предоставляемыми инвалиду (ребенку инвалиду) за счет средств бюджета субъекта Российской Федерации'),
(8,'восьмой','Данные об исполнении мероприятий, возложенных ИПРА инвалида (ИПРА ребенка-инвалида) на региональное отделение Фонда по обеспечению ТСР и услугами по реабилитации, предоставляемыми инвалиду (ребенку инвалиду) за счет средств федерального бюджета')
;
-- select * from RHB_GRP;

delete from RHB_TYPE;
insert into RHB_TYPE (ID,GRPID,NAME) values
(1, 1,''),
(2, 1,'Медицинская реабилитация'),
(3, 1,'Реконструктивная хирургия'),
(4, 1,'Протезирование, ортезирование'),
(5, 2,''),
(6, 2,'Обеспечение профессиональной ориентации инвалидов'),
(7, 2,'Профессиональное обучение и/или переобучение'),
(8, 2,'Условия для получения профессионального образования'),
(9, 2,'Содействие в трудоустройстве'),
(10,2,'Условия труда, предоставленные при трудоустройстве'),
(11,2,'Производственная адаптация'),
(12,2,'Оснащение (оборудование) специального рабочего места для трудоустройства инвалида'),
(13,3,''),
(14,3,'Условия по организации обучения'),
(15,3,'Психолого-педагогическая помощь'),
(16,4,''),
(17,4,'Социально-средовая реабилитация и абилитация'),
(18,4,'Социально-психологическая реабилитация и абилитация'),
(19,4,'Социально-педагогическая реабилитация и абилитация'),
(20,4,'Социокультурная реабилитация и абилитация'),
(21,4,'Социально-бытовая адаптация'),
(22,4,'Приспособление жилого помещения для нужд инвалида'),
(23,5,''),
(24,6,''),
(25,7,''),
(26,8,'')
;
--select * from RHB_TYPE;

delete from RHB_EVNT;
insert into RHB_EVNT (ID,TYPEID,NAME) values
(1, 2, 'Динамическое наблюдение'),
(2, 2, 'Лекарственная терапия'),
(3, 2, 'Немедикаментозная терапия'),
(4, 2, 'Прочие'),
(5, 6, 'Профессиональное информирование'),
(6, 6, 'Профессиональное консультирование'),
(7, 6, 'Профессиональный отбор'),
(8, 6, 'Профессиональный подбор'),
(9, 6, 'Прочие'),
(10,7, 'Профессиональное обучение по программам профессиональной подготовки'),
(11,7, 'Профессиональное обучение по программам переподготовки'),
(12,7, 'Профессиональное обучение по программам повышения квалификации'),
(13,8, 'Адаптированная образовательная программа'),
(14,8, 'Специальные условия для получения образования'),
(15,8, 'Условия для получения образования инвалидами, имеющими стойкие расстройства функции зрения'),
(16,8, 'Условия для получения образования инвалидами, имеющими стойкие расстройства функции слуха'),
(17,8, 'Условия для получения образования инвалидами, имеющими одновременные стойкие расстройства функций зрения и слуха'),
(18,8, 'Условия для получения образования инвалидами, имеющими стойкие расстройства функции опорно-двигательного аппарата'),
(19,8, 'Условия для получения образования инвалидами, имеющими стойкие расстройства функции опорно-двигательного аппарата, использующими кресла-коляски'),
(20,9, 'Содействие в трудоустройстве'),
(21,10,'Обычные условия труда'),
(22,10,'Специально созданные условия труда'),
(23,11,'Социально-психологическая адаптация'),
(24,11,'Социально-производственная адаптация'),
(25,12,'Для инвалидов, имеющих стойкие расстройства функции зрения'),
(26,12,'Для инвалидов, имеющих стойкие расстройства функции слуха'),
(27,12,'Для инвалидов, имеющих одновременные стойкие расстройства функций зрения и слуха'),
(28,12,'Для инвалидов, имеющих стойкие расстройства функции опорно-двигательного аппарата'),
(29,12,'Для инвалидов, имеющих стойкие расстройства функции опорно-двигательного аппарата, использующих кресла-коляски'),
(30,12,'Прочие'),
(31,14,'Общеобразовательная программа'),
(32,14,'Адаптированная основная образовательная программа'),
(33,14,'Специальные педагогические условия для получения образования'),
(34,15,'Психолого-педагогическое консультирование инвалида и его семьи'),
(35,15,'Педагогическая коррекция'),
(36,15,'Психолого-педагогическое сопровождение учебного процесса'),
(37,17,'Информирование и консультирование по вопросам социально-средовой реабилитации'),
(38,17,'Адаптационное обучение инвалидов и членов их семей пользованию техническими средствами реабилитации'),
(39,17,'Прочее'),
(40,18,'Консультирование по вопросам социально-психологической реабилитации'),
(41,18,'Психологическая диагностика'),
(42,18,'Психологическая коррекция'),
(43,18,'Социально-психологический тренинг'),
(44,18,'Социально-психологический патронаж инвалида, семьи инвалида'),
(45,19,'Социально-педагогическая диагностика'),
(46,19,'Социально-педагогическое консультирование'),
(47,19,'Психолого-педагогическое сопровождение учебного процесса'),
(48,19,'Педагогическая коррекция'),
(49,19,'Коррекционное обучение'),
(50,19,'Социально-педагогический патронаж и поддержка инвалида'),
(51,20,'Консультирование и обучение навыкам проведения досуга, отдыха, формирование культурно-прикладных навыков и интересов'),
(52,20,'Создание условий для полноценного участия в досуговых культурно-массовых мероприятиях и социокультурной деятельности'),
(53,21,'Консультирование инвалида и членов его семьи по вопросам адаптации жилья к нуждам инвалида'),
(54,21,'Адаптационное обучение инвалида и членов его семьи по вопросам самообслуживания и бытовой деятельности'),
(55,22,'Для инвалидов, имеющих стойкие расстройства функции опорно-двигательного аппарата, в том числе использующих кресла-коляски и иные вспомогательные средства передвижения'),
(56,22,'Для инвалидов, имеющих стойкие расстройства функции слуха, при необходимости использования вспомогательных средств'),
(57,22,'Для инвалидов, имеющих стойкие расстройства функции зрения. при необходимости использования собаки-проводника, иных вспомогательных средств'),
(58,22,'Для инвалидов, имеющих стойкие расстройства ментальных функций'),
(59,23,'Информирование и консультирование инвалида и членов его семьи по вопросам адаптивной физической культуры и адаптивного спорта'),
(60,23,'Интеграция инвалида в систему физической культуры, физического воспитания и спорта'),
(61,24,'Сопровождение инвалида к месту нахождения организации, в которую выдано направление для получения ТСР за счет средств федерального бюджета, и обратно'),
(62,26,'Сопровождение инвалида к месту нахождения организации, в которую выдано направление для получения ТСР за счет средств федерального бюджета, и обратно')
;
--select * from RHB_EVNT;

delete from RHB_GTSR;
insert into RHB_GTSR (ID,NAME) values
(1,'Трости опорные и тактильные, костыли, опоры, поручни'),
(2,'Кресла-коляски с ручным приводом (комнатные, прогулочные, активного типа),, с электроприводом, малогабаритные'),
(3,'Протезы, в том числе эндопротезы, и ортезы'),
(4,'Ортопедическая обувь'),
(5,'Противопролежневые матрацы и подушки'),
(6,'Приспособления для одевания, раздевания и захвата предметов'),
(7,'Специальная одежда'),
(8,'Специальные устройства для чтения "говорящих книг", для оптической коррекции слабовидения'),
(9,'Собаки-проводники с комплектом снаряжения'),
(10,'Медицинские термометры и тонометры с речевым выходом'),
(11,'Сигнализаторы звука световые и вибрационные'),
(12,'Слуховые аппараты, в том числе с ушными вкладышами индивидуального изготовления'),
(13,'Телевизоры с телетекстом для приема программ со скрытыми субтитрами'),
(14,'Телефонные устройства с текстовым выходом'),
(15,'Голосообразующие'),
(16,'Специальные средства при нарушениях функций выделения (моче- и калоприемники),'),
(17,'Абсорбирующее белье, подгузники'),
(18,'Кресла-стулья с санитарным оснащением'),
(19,'Эндопротезы и ортезы'),
(20,'Товары и услуги, предназначенные для социальной адаптации и интеграции в общество детей-инвалидов')
;
--select * from RHB_GTSR;

delete from RHB_TSR;
insert into RHB_TSR (ID,GTSRID,SCODE,NAME) values
(1,1,'6-06','Трость опорная с анатомической ручкой, регулируемая по высоте, с устройством противоскольжения'),
(2,1,'6-07','Трость опорная с анатомической ручкой, не регулируемая по высоте, без устройства противоскольжения'),
(3,1,'6-08','Трость опорная с анатомической ручкой, не регулируемая по высоте, с устройством противоскольжения'),
(4,1,'6-09','Трость 3-х опорная, регулируемая по высоте, без устройства противоскольжения'),
(5,1,'6-10','Трость 3-х опорная, регулируемая по высоте, с устройством противоскольжения'),
(6,1,'6-11','Трость 3-х опорная, не регулируемая по высоте, без устройства противоскольжения'),
(7,1,'6-12','Трость 3-х опорная, не регулируемая по высоте, с устройством противоскольжения'),
(8,1,'6-13','Трость 3-х опорная с анатомической ручкой, регулируемая по высоте, без устройства противоскольжения'),
(9,1,'6-14','Трость 3-х опорная с анатомической ручкой, регулируемая по высоте, с устройством противоскольжения'),
(10,1,'6-15','Трость 3-х опорная с анатомической ручкой, не регулируемая по высоте, без устройства противоскольжения'),
(11,1,'6-16','Трость 3-х опорная с анатомической ручкой, не регулируемая по высоте, с устройством противоскольжения'),
(12,1,'6-17','Трость 4-х опорная, регулируемая по высоте, без устройства противоскольжения'),
(13,1,'6-18','Трость 4-х опорная, регулируемая по высоте, с устройством противоскольжения'),
(14,1,'6-19','Трость 4-х опорная, не регулируемая по высоте, без устройства противоскольжения'),
(15,1,'6-20','Трость 4-х опорная, не регулируемая по высоте, с устройством противоскольжения'),
(16,1,'6-21','Трость 4-х опорная с анатомической ручкой, регулируемая по высоте, без устройства противоскольжения'),
(17,1,'6-22','Трость 4-х опорная с анатомической ручкой, регулируемая по высоте, с устройством противоскольжения'),
(18,1,'6-23','Трость 4-х опорная с анатомической ручкой, не регулируемая по высоте, без устройства противоскольжения'),
(19,1,'6-24','Трость 4-х опорная с анатомической ручкой, не регулируемая по высоте, с устройством противоскольжения'),
(20,1,'6-25','Трость белая тактильная гибкая составная'),
(21,1,'6-26','Трость белая тактильная гибкая телескопическая'),
(22,1,'6-27','Трость белая тактильная жесткая составная'),
(23,1,'6-28','Трость белая тактильная жесткая телескопическая'),
(24,1,'6-31','Костыли с опорой под локоть с устройством противоскольжения'),
(25,1,'6-32','Костыли с опорой под локоть без устройства противоскольжения'),
(26,1,'6-33','Костыли с опорой на предплечье с устройством противоскольжения'),
(27,1,'6-34','Костыли с опорой на предплечье без устройства противоскольжения'),
(28,1,'6-35','Костыли подмышечные с устройством противоскольжения'),
(29,1,'6-36','Костыли подмышечные без устройства противоскольжения'),
(30,1,'6-37','Опора в кровать веревочная'),
(31,1,'6-38','Опора в кровать металлическая'),
(32,1,'6-43','Ходунки шагающие'),
(33,1,'6-44','Ходунки на колесах'),
(34,1,'6-45','Ходунки с опорой на предплечье'),
(35,1,'6-46','Ходунки, изготавливаемые по индивидуальному заказу'),
(36,1,'6-47','Ходунки с подмышечной опорой'),
(37,1,'6-48','Ходунки-роллаторы'),
(38,1,'6-49','Поручни (перила) для самоподнимания угловые'),
(39,1,'6-50','Поручни (перила) для самоподнимания прямые (линейные)'),
(40,2,'7-06','Кресло-коляска с ручным приводом с откидной спинкой прогулочная, в том числе для детей-инвалидов'),
(41,2,'7-07','Кресло-коляска с ручным приводом с регулировкой угла наклона подножки (подножек) комнатная, в том числе для детей-инвалидов'),
(42,2,'7-08','Кресло-коляска с ручным приводом с регулировкой угла наклона подножки (подножек) прогулочная, в том числе для детей-инвалидов'),
(43,2,'7-09','Кресло-коляска с ручным приводом для больных ДЦП комнатная, в том числе для детей-инвалидов'),
(44,2,'7-10','Кресло-коляска с ручным приводом для больных ДЦП прогулочная, в том числе для детей-инвалидов'),
(45,2,'7-11','Кресло-коляска с рычажным приводом прогулочная, в том числе для детей-инвалидов'),
(46,2,'7-12','Кресло-коляска с приводом для управления одной рукой комнатная, в том числе для детей-инвалидов'),
(47,2,'7-13','Кресло-коляска с приводом для управления одной рукой прогулочная, в том числе для детей-инвалидов'),
(48,2,'7-14','Кресло-коляска с ручным приводом для лиц с большим весом комнатная, в том числе для детей-инвалидов'),
(49,2,'7-15','Кресло-коляска с ручным приводом для лиц с большим весом прогулочная, в том числе для детей-инвалидов'),
(50,2,'7-16','Кресло-коляска активного типа, в том числе для детей-инвалидов'),
(51,2,'7-17','Кресло-коляска с электроприводом комнатная, в том числе для детей-инвалидов'),
(52,2,'7-18','Кресло-коляска с электроприводом прогулочная, в том числе для детей-инвалидов'),
(53,2,'7-19','Кресло-коляска для больных ДЦП комнатная с электроприводом, в том числе для детей-инвалидов'),
(54,2,'7-20','Кресло-коляска для больных ДЦП прогулочная с электроприводом, в том числе для детей-инвалидов'),
(55,2,'7-21','Кресло-коляска малогабаритная (для инвалидов с высокой ампутацией нижних конечностей), в том числе для детей-инвалидов'),
(56,3,'8-09','Протез предплечья с внешним источником энергии'),
(57,3,'8-10','Протез плеча косметический'),
(58,3,'8-11','Протез плеча активный'),
(59,3,'8-12','Протез плеча рабочий'),
(60,3,'8-13','Протез плеча с внешним источником энергии'),
(61,3,'8-14','Протез после вычленения плеча с электромеханическим приводом и контактной системой управления'),
(62,3,'8-15','Протез после вычленения плеча функционально-косметический'),
(63,3,'8-16','Чехол на культю предплечья хлопчатобумажный'),
(64,3,'8-17','Чехол на культю плеча хлопчатобумажный'),
(65,3,'8-18','Чехол на культю верхней конечности из полимерного материала (силиконовый)'),
(66,3,'8-19','Косметическая оболочка на протез верхней конечности'),
(67,3,'8-20','Протез стопы'),
(68,3,'8-21','Протез голени лечебно-тренировочный'),
(69,3,'8-22','Протез голени немодульного типа, в том числе при врожденном недоразвитии'),
(70,3,'8-23','Протез голени модульного типа, в том числе при недоразвитии'),
(71,3,'8-24','Протез голени для купания'),
(72,3,'8-25','Чехол на культю голени шерстяной'),
(73,3,'8-26','Чехол на культю голени хлопчатобумажный'),
(74,3,'8-27','Чехол на культю голени из полимерного материала (силиконовый)'),
(75,3,'8-28','Протез бедра лечебно-тренировочный'),
(76,3,'8-29','Протез бедра немодульный'),
(77,3,'8-30','Протез бедра модульный'),
(78,3,'8-32','Протез бедра для купания'),
(79,3,'8-33','Протез при вычленении бедра немодульный'),
(80,3,'8-34','Протез при вычленении бедра модульный'),
(81,3,'8-35','Чехол на культю бедра шерстяной'),
(82,3,'8-36','Чехол на культю бедра хлопчатобумажный'),
(83,3,'8-37','Чехол на культю бедра из полимерного материала (силиконовый)'),
(84,3,'8-38','Косметическая оболочка на протез нижней конечности'),
(85,3,'8-39','Экзопротез молочной железы'),
(86,3,'8-40','Чехол для экзопротеза молочной железы трикотажный'),
(87,3,'8-41','Зубные протезы (кроме зубных протезов из драгоценных металлов и других дорогостоящих материалов, приравненных по стоимости к драгоценным металлам)'),
(88,3,'8-42','Глазной протез стеклянный'),
(89,3,'8-43','Глазной протез пластмассовый'),
(90,3,'8-44','Протез ушной'),
(91,3,'8-45','Протез носовой'),
(92,3,'8-46','Протез неба'),
(93,3,'8-48','Протез лицевой комбинированный, в том числе совмещенные протезы (ушной и/или носовой и/или глазницы)'),
(94,3,'8-49','Протез половых органов'),
(95,3,'8-115','Эндопротез лучезапястного сустава и сустава кисти'),
(96,3,'8-116','Эндопротез локтевого сустава'),
(97,3,'8-117','Эндопротез плечевого сустава'),
(98,3,'8-118','Эндопротез голеностопного сустава и сустава стопы'),
(99,3,'8-119','Эндопротез коленного сустава'),
(100,3,'8-120','Эндопротез тазобедренного сустава'),
(101,3,'8-121','Эндопротез клапанов сердца'),
(102,3,'8-122','Кохлеарный имплантант'),
(103,3,'8-123','Эндопротез сосудов'),
(104,3,'8-124','Интраокулярная линза'),
(105,3,'8-50','Бандаж ортопедический на верхнюю конечность для улучшения лимфовенозного оттока, в том числе после ампутации молочной железы'),
(106,3,'8-51','Бандаж грыжевой (паховый) односторонний на жестком поясе с пружиной'),
(107,3,'8-65','Бандаж-суспензорий'),
(108,3,'8-66','Бандаж на лучезапястный сустав'),
(109,3,'8-67','Бандаж на запястье'),
(110,3,'8-68','Бандаж на локтевой сустав'),
(111,3,'8-69','Бандаж на плечевой сустав'),
(112,3,'8-70','Бандаж на верхнюю конечность - "косынка"'),
(113,3,'8-71','Головодержатель полужесткой фиксации'),
(114,3,'8-72','Головодержатель жесткой фиксации'),
(115,3,'8-73','Бандаж на шейный отдел позвоночника'),
(116,3,'8-74','Бандаж на тазобедренный сустав'),
(117,3,'8-75','Бандаж на коленный сустав (наколенник)'),
(118,3,'8-76','Бандаж на голеностопный сустав'),
(119,3,'8-78','Бюстгальтер для экзопротеза молочной железы'),
(120,3,'8-79','Грация (или полуграция) для фиксации экзопротеза молочной железы'),
(121,3,'8-80','Корсет мягкой фиксации'),
(122,3,'8-81','Корсет полужесткой фиксации'),
(123,3,'8-82','Корсет жесткой фиксации'),
(124,3,'8-83','Корсет функционально-корригирующий'),
(125,3,'8-84','Реклинатор - корректор осанки'),
(126,3,'8-85','Аппарат на кисть'),
(127,3,'8-86','Аппарат на кисть и лучезапястный сустав'),
(128,3,'8-87','Аппарат на лучезапястный сустав'),
(129,3,'8-88','Аппарат на локтевой сустав'),
(130,3,'8-89','Аппарат на кисть, лучезапястный и локтевой суставы'),
(131,3,'8-90','Аппарат на лучезапястный и локтевой суставы'),
(132,3,'8-91','Аппарат на локтевой и плечевой суставы'),
(133,3,'8-92','Аппарат на лучезапястный, локтевой и плечевой суставы'),
(134,3,'8-93','Аппарат на плечевой сустав'),
(135,3,'8-94','Аппарат на всю руку'),
(136,3,'8-95','Аппарат на голеностопный сустав'),
(137,3,'8-96','Аппарат на голеностопный и коленный суставы'),
(138,3,'8-97','Аппарат на коленный сустав'),
(139,3,'8-98','Аппарат на тазобедренный сустав'),
(140,3,'8-99','Аппарат на коленный и тазобедренный суставы'),
(141,3,'8-100','Аппарат на всю ногу'),
(142,3,'8-101','Аппарат на нижние конечности и туловище (ортез)'),
(143,3,'8-102','Тутор на лучезапястный сустав'),
(144,3,'8-103','Тутор на предплечье'),
(145,3,'8-104','Тутор на локтевой сустав'),
(146,3,'8-105','Тутор на плечевой сустав'),
(147,3,'8-106','Тутор на всю руку'),
(148,3,'8-107','Тутор на голеностопный сустав'),
(149,3,'8-108','Тутор косметический на голень'),
(150,3,'8-109','Тутор на коленный сустав'),
(151,3,'8-110','Тутор на тазобедренный сустав'),
(152,3,'8-111','Тутор на коленный и тазобедренный суставы'),
(153,3,'8-112','Тутор на всю ногу'),
(154,3,'8-113','Обувь на протез'),
(155,16,'21-13','Пояс для калоприемников и уроприемников'),
(156,16,'21-14','Калоприемник из пластмассы на поясе в комплекте с мешками'),
(157,16,'','Адгезивная пластина для двухкомпонентного уроприемника'),
(158,16,'','Уростомный мешок для двухкомпонентного уроприемника'),
(159,16,'21-05','Однокомпонентный дренируемый уроприемник со встроенной плоской пластиной'),
(160,16,'21-15','Мочеприемник ножной (мешок для сбора мочи), дневной'),
(161,16,'21-16','Мочеприемник прикроватный (мешок для сбора мочи), ночной'),
(162,16,'21-17','Пара ремешков для крепления мочеприемников (мешков для сбора мочи) к ноге'),
(163,16,'21-20','Катетер для самокатетеризации лубрицированный'),
(164,16,'21-24','Катетер для эпицистостомы'),
(165,16,'21-25','Катетер для нефростомы'),
(166,16,'21-23','Катетер уретральный постоянного пользования'),
(167,16,'21-18','Уропрезерватив с пластырем'),
(168,16,'21-29','Паста-герметик для защиты и выравнивания кожи вокруг стомы в тубе, не менее 60 г'),
(169,16,'21-31','Крем защитный в тубе, не менее 60 мл'),
(170,16,'21-32','Пудра (порошок) абсорбирующая в тубе, не менее 25 г'),
(171,16,'21-33','Защитная пленка во флаконе, не менее 50 мл'),
(172,16,'21-35','Очиститель для кожи во флаконе, не менее 180 мл'),
(173,16,'21-27','Анальный тампон (средство ухода при недержании кала)'),
(174,16,'21-28','Ирригационная система для опорожнения кишечника через колостому'),
(175,17,'22-05','Подгузники для взрослых размер "XS" (объем талии не менее 40 - 60 см), впитываемостью не менее 1300 мл'),
(176,17,'22-06','Подгузники для взрослых размер "XS" (объем талии не менее 40 - 60 см), впитываемостью не менее 1500 мл'),
(177,17,'22-07','Подгузники для взрослых размер "XS" (объем талии не менее 40 - 60 см), впитываемостью не менее 1700 мл'),
(178,17,'22-08','Подгузники для взрослых размер "XS" (объем талии не менее 40 - 60 см), впитываемостью не менее 1800 мл'),
(179,17,'22-09','Подгузники для взрослых размер "S" (объем талии не менее 60 - 80 см), впитываемостью не менее 800 мл'),
(180,17,'22-10','Подгузники для взрослых размер "S" (объем талии не менее 60 - 80 см), впитываемостью не менее 1300 мл'),
(181,17,'22-11','Подгузники для взрослых размер "S" (объем талии не менее 60 - 80 см), впитываемостью не менее 1500 мл'),
(182,17,'22-12','Подгузники для взрослых размер "S" (объем талии не менее 60 - 80 см), впитываемостью не менее 1700 мл'),
(183,17,'22-13','Подгузники для взрослых размер "S" (объем талии не менее 60 - 80 см), впитываемостью не менее 1800 мл'),
(184,17,'22-14','Подгузники для взрослых размер "M" (объем талии не менее 70 - 110 см), впитываемостью не менее 800 мл'),
(185,17,'22-15','Подгузники для взрослых размер "M" (объем талии не менее 70 - 110 см), впитываемостью не менее 900 мл'),
(186,17,'22-16','Подгузники для взрослых размер "M" (объем талии не менее 70 - 110 см), впитываемостью не менее 1500 мл'),
(187,17,'22-17','Подгузники для взрослых размер "M" (объем талии не менее 70 - 110 см), впитываемостью не менее 2000 мл'),
(188,17,'22-18','Подгузники для взрослых размер "M" (объем талии не менее 70 - 110 см), впитываемостью не менее 2100 мл'),
(189,17,'22-19','Подгузники для взрослых размер "M" (объем талии не менее 70 - 110 см), впитываемостью не менее 2310 мл'),
(190,17,'22-20','Подгузники для взрослых размер "M" (объем талии не менее 70 - 110 см), впитываемостью не менее 3600 мл'),
(191,17,'22-21','Подгузники для взрослых размер "L" (объем талии не менее 100 - 150 см), впитываемостью не менее 800 мл'),
(192,17,'22-22','Подгузники для взрослых размер "L" (объем талии не менее 100 - 150 см), впитываемостью не менее 1100 мл'),
(193,17,'22-23','Подгузники для взрослых размер "L" (объем талии не менее 100 - 150 см), впитываемостью не менее 1500 мл'),
(194,17,'22-24','Подгузники для взрослых размер "L" (объем талии не менее 100 - 150 см), впитываемостью не менее 2100 мл'),
(195,17,'22-25','Подгузники для взрослых размер "L" (объем талии не менее 100 - 150 см), впитываемостью не менее 2200 мл'),
(196,17,'22-26','Подгузники для взрослых размер "L" (объем талии не менее 100 - 150 см), впитываемостью не менее 2400 мл'),
(197,17,'22-27','Подгузники для взрослых размер "L" (объем талии не менее 100 - 150 см), впитываемостью не менее 2700 мл'),
(198,17,'22-28','Подгузники для взрослых размер "L" (объем талии не менее 100 - 150 см), впитываемостью не менее 4100 мл'),
(199,17,'22-29','Подгузники для взрослых размер "XL" (объем талии не менее 120 - 160 см), впитываемостью не менее 1500 мл'),
(200,17,'22-30','Подгузники для взрослых размер "XL" (объем талии не менее 120 - 160 см), впитываемостью не менее 2100 мл'),
(201,17,'22-31','Подгузники для взрослых размер "XL" (объем талии не менее 120 - 160 см), впитываемостью не менее 2140 мл'),
(202,17,'22-32','Подгузники для взрослых размер "XL" (объем талии не менее 120 - 160 см) впитываемостью не менее 3300 мл'),
(203,17,'','Подгузники для взрослых, размер "XL" (объем талии не менее 120 - 160 см), впитываемостью не менее 3300 мл'),
(204,17,'22-33','Подгузники для детей весом от 3 до 6 кг'),
(205,17,'22-34','Подгузники для детей весом от 4 до 9 кг'),
(206,17,'22-35','Подгузники для детей весом от 7 до 18 кг'),
(207,17,'22-36','Подгузники для детей весом от 11 до 25 кг'),
(208,17,'22-37','Подгузники для детей весом от 15 до 30 кг'),
(209,1,'6-01','Трость опорная, регулируемая по высоте, без устройства противоскольжения'),
(210,1,'6-02','Трость опорная, регулируемая по высоте, с устройством противоскольжения'),
(211,1,'6-03','Трость опорная, не регулируемая по высоте, без устройства противоскольжения'),
(212,1,'6-04','Трость опорная, не регулируемая по высоте, с устройством противоскольжения'),
(213,1,'6-05','Трость опорная с анатомической ручкой, регулируемая по высоте, без устройства противоскольжения'),
(214,2,'7-01','Кресло-коляска с ручным приводом базовая комнатная, в том числе для детей-инвалидов'),
(215,2,'7-02','Кресло-коляска с ручным приводом базовая прогулочная, в том числе для детей-инвалидов'),
(216,2,'7-03','Кресло-коляска с ручным приводом с жестким сидением и спинкой комнатная, втом числе для детей-инвалидов'),
(217,2,'7-04','Кресло-коляска с ручным приводом с жестким сидением и спинкой прогулочная,в том числе для детей-инвалидов'),
(218,2,'7-05','Кресло-коляска с ручным приводом с откидной спинкой комнатная, в том числедля детей-инвалидов'),
(219,3,'8-01','Протез пальца косметический'),
(220,3,'8-02','Протез кисти косметический, в том числе при вычленении и частичном вычленении кисти'),
(221,3,'8-06','Протез предплечья косметический'),
(222,3,'8-07','Протез предплечья активный'),
(223,3,'8-08','Протез предплечья рабочий'),
(224,4,'9-01','Обувь ортопедическая малосложная без утепленной подкладки'),
(225,4,'9-02','Обувь ортопедическая малосложная на утепленной подкладке'),
(226,4,'9-03','Обувь ортопедическая сложная без утепленной подкладки'),
(227,4,'9-04','Обувь ортопедическая сложная на утепленной подкладке'),
(228,4,'9-05','Обувь ортопедическая при односторонней ампутации без утепленной подкладки'),
(229,4,'9-06','Обувь ортопедическая при односторонней ампутации на утепленной подкладке'),
(230,4,'9-07','Вкладные корригирующие элементы для ортопедической обуви (в том числе стельки, полустельки)'),
(231,4,'9-08','Вкладной башмачок'),
(232,5,'10-01','Противопролежневый матрац полиуретановый'),
(233,5,'10-02','Противопролежневый матрац гелевый'),
(234,5,'10-03','Противопролежневый матрац воздушный (с компрессором)'),
(235,5,'10-04','Противопролежневая подушка полиуретановая'),
(236,5,'10-05','Противопролежневая подушка гелевая'),
(237,5,'10-06','Противопролежневая подушка воздушная'),
(238,6,'11-01','Приспособление для надевания рубашек'),
(239,6,'11-02','Приспособление для надевания колгот'),
(240,6,'11-03','Приспособление для надевания носков'),
(241,6,'11-04','Приспособление (крючок) для застегивания пуговиц'),
(242,6,'11-05','Захват активный'),
(243,6,'11-06','Захват для удержания посуды'),
(244,6,'11-07','Захват для открывания крышек'),
(245,6,'11-08','Захват для ключей'),
(246,6,'11-09','Крюк на длинной ручке (для открывания форточек, створок окна и т.д.)'),
(247,7,'12-01','Комплект функционально-эстетической одежды для инвалидов с парной ампутацией верхних конечностей'),
(248,7,'12-02','Ортопедические брюки'),
(249,7,'12-03','Рукавицы утепленные кожаные на меху (для инвалидов, пользующихся малогабаритными креслами-колясками)'),
(250,7,'12-04','Шерстяной чехол на культю бедра (для инвалидов, пользующихся малогабаритными креслами-колясками)'),
(251,7,'12-05','Пара кожаных или трикотажных перчаток (на протез верхней конечности)'),
(252,7,'12-06','Кожаная перчатка на утепленной подкладке на кисть сохранившейся верхней конечности'),
(253,7,'12-07','Пара кожаных перчаток на деформированные верхние конечности'),
(254,8,'13-01','Специальное устройство для чтения "говорящих книг" на флэш-картах'),
(255,8,'13-02','Электронный ручной видеоувеличитель'),
(256,8,'13-03','Электронный стационарный видеоувеличитель'),
(257,8,'13-04','Лупа'),
(258,8,'13-05','Лупа с подсветкой'),
(259,9,'14-01','Собака-проводник с комплектом снаряжения'),
(260,10,'15-01','Медицинский термометр с речевым выходом'),
(261,10,'15-02','Медицинский тонометр с речевым выходом'),
(262,11,'16-01','Сигнализатор звука цифровой со световой индикацией'),
(263,11,'16-02','Сигнализатор звука цифровой с вибрационной индикацией'),
(264,11,'16-03','Сигнализатор звука цифровой с вибрационной и световой индикацией'),
(265,12,'17-01','Слуховой аппарат аналоговый заушный сверхмощный'),
(266,12,'17-02','Слуховой аппарат аналоговый заушный мощный'),
(267,12,'17-03','Слуховой аппарат аналоговый заушный средней мощности'),
(268,12,'17-04','Слуховой аппарат аналоговый заушный слабой мощности'),
(269,12,'17-05','Слуховой аппарат цифровой заушный сверхмощный'),
(270,12,'17-06','Слуховой аппарат цифровой заушный мощный'),
(271,12,'17-07','Слуховой аппарат цифровой заушный средней мощности'),
(272,12,'17-08','Слуховой аппарат цифровой заушный слабой мощности'),
(273,12,'17-09','Слуховой аппарат карманный супермощный'),
(274,12,'17-10','Слуховой аппарат карманный мощный'),
(275,12,'17-11','Слуховой аппарат цифровой заушный для открытого протезирования'),
(276,12,'17-13','Вкладыш ушной индивидуального изготовления (для слухового аппарата)'),
(277,13,'18-01','Телевизор с телетекстом для приема программ со скрытыми субтитрами, с диагональю 54-66 см'),
(278,14,'19-01','Телефонное устройство с текстовым выходом'),
(279,15,'20-01','Голосообразующий аппарат'),
(280,16,'21-01','Однокомпонентный дренируемый калоприемник со встроенной плоской пластиной'),
(281,16,'','Однокомпонентный дренируемый калоприемник'),
(282,16,'21-03','Однокомпонентный недренируемый калоприемник со встроенной плоской пластиной'),
(283,16,'','Мешок дренируемый для двухкомпонентного калоприемника'),
(284,16,'','Мешок недренируемый для двухкомпонентного калоприемника'),
(285,17,'22-01','Впитывающие простыни (пеленки) размером не менее 40 x 60 см (впитываемостью от 400 до 500 мл)'),
(286,17,'22-02','Впитывающие простыни (пеленки) размером не менее 60 x 60 см (впитываемостью от 800 до 1200 мл)'),
(287,17,'22-03','Впитывающие простыни (пеленки) размером не менее 60 x 90 см (впитываемостью от 1200 до 1900 мл)'),
(288,17,'22-04','Подгузники для взрослых размер "XS" (объем талии не менее 40 - 60 см), впитываемостью не менее 800 мл'),
(289,18,'23-01','Кресло-стул с санитарным оснащением активного типа'),
(290,18,'23-02','Кресло-стул с санитарным оснащением (с колесами)'),
(291,18,'23-03','Кресло-стул с санитарным оснащением (без колес)'),
(292,18,'23-04','Кресло-стул с санитарным оснащением пассивного типа повышенной грузоподъемности (без колес)'),
(293,3,'8-31','Протез бедра модульный с внешним источником энергии'),
(294,3,'8-47','Протез голосовой'),
(295,3,'8-77','Бандаж компрессионный на нижнюю конечность'),
(296,3,'8-114','Обувь на аппарат'),
(297,1,'6-29','Трость белая опорная с устройством противоскольжения'),
(298,1,'6-30','Трость белая опорная без устройства противоскольжения'),
(299,1,'6-39','Опора для ползания для детей-инвалидов'),
(300,1,'6-40','Опора для сидения для детей-инвалидов'),
(301,1,'6-41','Опора для лежания для детей-инвалидов'),
(302,1,'6-42','Опора для стояния для детей-инвалидов'),
(303,3,'8-03','Протез кисти рабочий, в том числе при вычленении и частичном вычленении кисти'),
(304,3,'8-04','Протез кисти активный, в том числе при вычленении и частичном вычленении кисти'),
(305,3,'8-05','Протез кисти с внешним источником энергии, в том числе при вычленении и частичном вычленении кисти'),
(306,3,'8-52','Бандаж грыжевой (паховый) односторонний на эластичном поясе'),
(307,3,'8-53','Бандаж грыжевой (паховый) двусторонний на жестком поясе с пружиной'),
(308,3,'8-54','Бандаж грыжевой (паховый) двусторонний на эластичном поясе'),
(309,3,'8-55','Бандаж грыжевой (скротальный) односторонний на жестком поясе с пружиной'),
(310,3,'8-56','Бандаж грыжевой (скротальный) односторонний на эластичном поясе'),
(311,3,'8-57','Бандаж грыжевой (скротальный) двусторонний на жестком поясе с пружиной'),
(312,3,'8-58','Бандаж грыжевой (скротальный) двусторонний на эластичном поясе'),
(313,3,'8-59','Бандаж грыжевой (комбинированный) односторонний на жестком поясе с пружиной'),
(314,3,'8-60','Бандаж грыжевой (комбинированный) односторонний на эластичном поясе'),
(315,3,'8-61','Бандаж грыжевой (комбинированный) двусторонний на жестком поясе с пружиной'),
(316,3,'8-62','Бандаж грыжевой (комбинированный) двусторонний на эластичном поясе'),
(317,3,'8-63','Бандаж ортопедический поддерживающий или фиксирующий из хлопчатобумажных или эластичных тканей, в том числе бандаж-грация- трусы, бандаж-трусы, бандаж-панталоны на область живота при ослаблении мышц брюшной стенки, опущении органов, после операций на органах брюшной полости'),
(318,3,'8-64','Бандаж торакальный ортопедический после операции на сердце и при травмах грудной клетки'),
(319,12,'17-12','Слуховой аппарат костной проводимости (неимплантируемый)'),
(320,16,'21-02','Однокомпонентный дренируемый калоприемник со встроенной конвексной пластиной'),
(321,16,'21-04','Однокомпонентный недренируемый калоприемник со встроенной конвексной пластиной'),
(322,16,'21-06','Однокомпонентный дренируемый уроприемник со встроенной конвексной пластиной'),
(323,16,'21-07','Двухкомпонентный дренируемый калоприемник в комплекте: адгезивная пластина, плоская; мешок дренируемый'),
(324,16,'21-08','Двухкомпонентный дренируемый калоприемник для втянутых стом в комплекте: адгезивная пластина, конвексная; мешок дренируемый'),
(325,16,'21-09','Двухкомпонентный недренируемый калоприемник в комлекте: адгезивная пластина, плоская; мешок недренируемый'),
(326,16,'21-10','Двухкомпонентный недренируемый калоприемник для втянутых стом в комплекте:адгезивная пластина конвексная; мешок недренируемый'),
(327,16,'21-11','Двухкомпонентный дренируемый уроприемник в комплекте: адгезивная пластина,плоская; уростомный мешок'),
(328,16,'21-12','Двухкомпонентный дренируемый уроприемник для втянутых стом в комплекте: адгезивная пластина, конвексная; уростомный мешок'),
(329,16,'21-19','Уропрезерватив самоклеящийся'),
(330,16,'21-21','Наборы- мочеприемники для самокатетеризации: мешок- мочеприемник, катетер лубрицированный для самокатетеризации, емкость с раствором хлорида натрия'),
(331,16,'21-22','Катетер уретральный длительного пользования'),
(332,16,'21-26','Катетер мочеточниковый для уретерокутанеостомы'),
(333,16,'21-30','Паста-герметик для защиты и выравнивания кожи вокруг стомы в полосках, не менее 60 г'),
(334,16,'21-34','Защитная пленка в форме салфеток, не менее 30 шт.'),
(335,16,'21-36','Очиститель для кожи в форме салфеток, не менее 30 шт.'),
(336,16,'21-37','Нейтрализатор запаха во флаконе, не менее 50 мл'),
(337,16,'21-38','Абсорбирующие желирующие пакетики для стомных мешков, 30 шт.'),
(338,16,'21-39','Адгезивная пластина-полукольцо для дополнительной фиксации пластин калоприемников и уроприемников, не менее 40 шт.'),
(339,16,'21-40','Адгезивная пластина - кожный барьер'),
(340,16,'21-41','Защитные кольца для кожи вокруг стомы'),
(341,16,'21-42','Тампон для стомы'),
(342,1,'код отсутствует','Трость тактильная гибкая составная'),
(343,1,'код отсутствует','Трость тактильная гибкая телескопическая'),
(344,1,'код отсутствует','Трость тактильная жесткая составная'),
(345,1,'код отсутствует','Трость тактильная жесткая телескопическая'),
(346,3,'код отсутствует','Бандаж грыжевой (паховый)'),
(347,3,'код отсутствует','Тутор на тазобедренный сустав'),
(348,16,'код отсутствует','Адгезивная пластина для двухкомпонентного калоприемника'),
(349,16,'код отсутствует','Адгезивная пластина для двухкомпонентного уроприемника'),
(350,16,'код отсутствует','Уростомный мешок для двухкомпонентного уроприемника'),
(351,16,'код отсутствует','Мешок дренируемый для двухкомпонентного калоприемника'),
(352,16,'код отсутствует','Мешок недренируемый для двухкомпонентного калоприемника'),
(353,16,'код отсутствует','Пояс для калоприемников и уроприемнков'),
(354,16,'код отсутствует','Однокомпонентный дренируемый калоприемник'),
(355,16,'код отсутствует','Однокомпонентный недренируемый калоприемник'),
(356,16,'код отсутствует','Однокомпонентный дренируемый уроприемник'),
(357,16,'код отсутствует','Мешок для сбора мочи (дневной)'),
(358,16,'код отсутствует','Мешок для сбора мочи (ночной)'),
(359,16,'код отсутствует','Ремешок для крепления к ноге мешков для сбора мочи'),
(360,16,'код отсутствует','Уропрезерватив'),
(361,16,'код отсутствует','Катетер уретральный постоянный'),
(362,16,'код отсутствует','Средство для опорожнения колостомы'),
(363,16,'код отсутствует','Паста-герметик для защиты и выравнивания кожи вокруг стомы'),
(364,16,'код отсутствует','Крем защитный (тюбик)'),
(365,16,'код отсутствует','Порошок (пудра) абсорбирующий'),
(366,16,'код отсутствует','Защитная пленка'),
(367,16,'код отсутствует','Очиститель для кожи'),
(368,1,'6-25','Трость белая тактильная цельная'),
(369,1,'6-26','Трость белая тактильная складная'),
(370,1,'6-27','Трость белая опорная не регулируемая по высоте с устройством противоскольжения'),
(371,1,'6-28','Трость белая опорная не регулируемая по высоте без устройства противоскольжения'),
(372,1,'6-29','Трость белая опорная регулируемая по высоте с устройством противоскольжения'),
(373,1,'6-30','Трость белая опорная регулируемая по высоте без устройства противоскольжения'),
(374,16,'21-25','Система (с катетером) для нефростомии'),
(375,19,'','Эндопротез верхних конечностей'),
(376,19,'','Эндопротез нижних конечностей'),
(377,19,'','Эндопротез клапанов сердца'),
(378,19,'','Кохлеарный имплантант'),
(379,19,'','Эндопротез сосудов'),
(380,19,'','Интраокулярная линза'),
(381,19,'','Ортез'),
(382,20,'09 33 21','Ванны переносные и складывающиеся'),
(383,20,'12 18 06','Велосипеды трехколесные с ножным приводом'),
(384,20,'12 12 18','Вспомогательные средства для перемещения человека, сидящего в кресле-коляске, при посадке в транспортное средство или высадке из него'),
(385,20,'22 36 21','Вспомогательные средства для позиционирования курсора и выбора нужного пункта на дисплее компьютера'),
(386,20,'27 06 21','Вспомогательные средства и инструменты для измерения климатических параметров'),
(387,20,'05 33 06','Вспомогательные средства обучения повседневной персональной деятельности'),
(388,20,'12 39 06','Вспомогательные средства ориентации электронные'),
(389,20,'22 39 05','Дисплеи компьютерные тактильные'),
(390,20,'22 12 06','Доски для письма, доски для черчения и доски для рисования'),
(391,20,'30 03 09','Игры'),
(392,20,'22 36 03','Клавиатуры'),
(393,20,'22 33 03','Компьютеры настольные, непортативные'),
(394,20,'22 33 06','Компьютеры портативные и персональные цифровые ассистенты (PDA)'),
(395,20,'09 33 03','Кресла для ванны (душа) на колесиках или без них, доски для ванны, табуретки, спинки и сиденья'),
(396,20,'18 09 09','Кресла функциональные'),
(397,20,'18 12 10','Кровати и съемные кровати-платформы (подматрацные платформы) с механической регулировкой'),
(398,20,'18 12 07','Кровати и съемные кровати-платформы (подматрацные платформы) с ручной регулировкой'),
(399,20,'12 17 03','Лестничные подъемные устройства'),
(400,20,'22 03 06','Линзы для коррекции зрения (линзы контактные, линзы для очков для коррекции зрения)'),
(401,20,'18 10 24','Лотки наколенные или столы, прикрепляемые к креслам'),
(402,20,'22 27 27','Материалы для маркировки и инструменты для маркировки'),
(403,20,'22 12 15','Машинки пишущие'),
(404,20,'22 15 06','Машины для расчетов'),
(405,20,'22 30 21','Машины читающие'),
(406,20,'22 06 24','Наушники'),
(407,20,   '04 48','Оборудование для тренировки опорно-двигательного и вестибулярного аппаратов'),
(408,20,'22 30 15','Подставки для книг и книгодержатели'),
(409,20,'12 12 15','Подъемники для перемещения человека, не сидящего в кресле-коляске, при посадке в транспортное средство или высадке из него'),
(410,20,'18 30 11','Подъемники лестничные с платформами'),
(411,20,'12 36 04','Подъемники мобильные для перемещения людей в положении стоя'),
(412,20,'12 36 03','Подъемники мобильные для перемещения людей, сидящих на сиденьях, подвешенных на канатах (стропах)'),
(413,20,'12 36 12','Подъемники стационарные, прикрепленные к стене, полу или потолку'),
(414,20,   '18 09','Предметы мебели для сидения'),
(415,20,'22 12 12','Приборы для письма алфавитом Брайля'),
(416,20,   '18 10','Принадлежности мебели для сидения'),
(417,20,'18 30 15','Рампы передвижные'),
(418,20,'22 12 18','Специальная бумага (пластик для письма)'),
(419,20,'22 27 16','Средства для поддержания памяти'),
(420,20,'22 12 03','Средства для рисования и рукописи'),
(421,20,   '18 03','Столы'),
(422,20,'24 36 12','Тележки'),
(423,20,'22 24 06','Телефонные аппараты для мобильных сетей'),
(424,20,'22 36 12','Устройства ввода альтернативные'),
(425,20,'22 12 21','Устройства для записи алфавитом Брайля, портативные'),
(426,20,'22 18 30','Устройства индукционно-петлевые'),
(427,20,'04 24 12','Устройства, оборудование и материалы для анализа крови'),
(428,20,'22 27 12','Часы и хронометры'),
(429,20,        '','Услуги чтеца-секретаря'),
(430,3,  '8-96','Бандаж на лучезапястный сустав'),
(431,17,'22-04','Подгузники для взрослых, размер "XS" (объем талии/бедер до 60 см), с полным влагопоглощением не менее 1000 г'),
(432,17,'22-05','Подгузники для взрослых, размер "XS" (объем талии/бедер до 60 см), с полным влагопоглощением не менее 1200 г'),
(433,17,'22-06','Подгузники для взрослых, размер "S" (объем талии/бедер до 90 см), с полным влагопоглощением не менее 1000 г'),
(434,17,'22-07','Подгузники для взрослых, размер "S" (объем талии/бедер до 90 см), с полным влагопоглощением не менее 1400 г'),
(435,17,'22-08','Подгузники для взрослых, размер "M" (объем талии/бедер до 120 см), с полным влагопоглощением не менее 1300 г'),
(436,17,'22-09','Подгузники для взрослых, размер "M" (объем талии/бедер до 120 см), с полным влагопоглощением не менее 1800 г'),
(437,17,'22-10','Подгузники для взрослых, размер "L" (объем талии/бедер до 150 см), с полным влагопоглощением не менее 1450 г'),
(438,17,'22-11','Подгузники для взрослых, размер "L" (объем талии/бедер до 150 см), с полным влагопоглощением не менее 2000 г'),
(439,17,'22-12','Подгузники для взрослых, размер "XL" (объем талии/бедер до 175 см), с полным влагопоглощением не менее 1450 г'),
(440,17,'22-13','Подгузники для взрослых, размер "XL" (объем талии/бедер до 175 см), с полным влагопоглощением не менее 2800 г'),
(441,17,'22-14','Подгузники для детей весом до 5 кг'),
(442,17,'22-15','Подгузники для детей весом до 6 кг'),
(443,17,'22-16','Подгузники для детей весом до 9 кг'),
(444,17,'22-17','Подгузники для детей весом до 20 кг'),
(445,17,'22-18','Подгузники для детей весом свыше 20 кг')
;
--select * from RHB_TSR;

delete from RHB_RES;
insert into RHB_RES (ID,SHNAME,NAME) values
(1,'выполнено','Выполнено'),
(2,'не выполнено','Инвалид (ребенок-инвалид) либо законный (уполномоченный) представитель не обратился в соответствующий орган государственной власти, орган местного самоуправления, организацию независимо от организационно-правовых форм за предоставлением мероприятий, предусмотренных ИПРА инвалида (ИПРА ребенка-инвалида)'),
(3,'не выполнено','Инвалид (ребенок-инвалид) либо законный (уполномоченный) представитель отказался от того или иного вида, формы и объема мероприятий, предусмотренных ИПРА инвалида (ИПРА ребенка-инвалида)'),
(4,'не выполнено','Инвалид (ребенок-инвалид) либо законный (уполномоченный) представитель отказался от реализации ИПРА инвалида (ИПРА ребенка-инвалида) в целом'),
(5,'не выполнено','Причины неисполнения мероприятий, предусмотренных ИПРА инвалида (ИПРА ребенка-инвалида), при согласии инвалида (ребенка-инвалида) либо законного (уполномоченного) представителя на их реализацию')
;
-- select * from RHB_RES;

-- Продвигаем версию
delete from APP_VER;
insert into APP_VER (ID,NAME,VERS) values
(1,'TBL','1.0.4'),
(2,'DIC','1.0.4')
;
--select * from APP_VER;

