/*==============================================================*/
/* DBMS name:      PostgreSQL 8                                 */
/* Created on:     23/06/2016 02:01:52 p.m.                     */
/*==============================================================*/


drop index PUEDE_TENER_FK;

drop index ANSWER_ELEMENT_PK;

drop table ANSWER_ELEMENT;

drop index AREA_PK;

drop table AREA;

drop index RELATIONSHIP_14_FK;

drop index RELATIONSHIP_13_FK;

drop index ASSOCIATION_PK;

drop table ASSOCIATION;

drop index PUEDE_TENER_1_FK;

drop index KEY_WORD_PK;

drop table KEY_WORD;

drop index TIENE_12_FK;

drop index PERTENECE_FK;

drop index QUESTION_PK;

drop table QUESTION;

drop index CREAR_FK;

drop index TEST_PK;

drop table TEST;

drop index TIENE_1_FK;

drop index TEST_CUESTION_PK;

drop table TEST_QUESTION;

drop index REALIZA_1_FK;

drop index RESUELTO_FK;

drop index TEST_TAKEN_PK;

drop table TEST_TAKEN;

drop index TYPE_CUESTION_PK;

drop table TYPE_CUESTION;

drop index RELATIONSHIP_12_FK;

drop index RESPONDIO_FK;

drop index USER_ANSWER_PK;

drop table USER_ANSWER;

drop index USER_PK;

drop table USER_SYSTEM;

/*==============================================================*/
/* Table: ANSWER_ELEMENT                                        */
/*==============================================================*/
create table ANSWER_ELEMENT (
   ID_ANSWER_ELEMENT    SERIAL not null,
   ID_QUESTION          INT4                 not null,
   CONTENT              TEXT                 not null,
   ORDER_VAR            VARCHAR(24)          not null,
   IS_CORRECT           BOOL                 not null,
   constraint PK_ANSWER_ELEMENT primary key (ID_ANSWER_ELEMENT)
);

/*==============================================================*/
/* Index: ANSWER_ELEMENT_PK                                     */
/*==============================================================*/
create unique index ANSWER_ELEMENT_PK on ANSWER_ELEMENT (
ID_ANSWER_ELEMENT
);

/*==============================================================*/
/* Index: PUEDE_TENER_FK                                        */
/*==============================================================*/
create  index PUEDE_TENER_FK on ANSWER_ELEMENT (
ID_QUESTION
);

/*==============================================================*/
/* Table: AREA                                                  */
/*==============================================================*/
create table AREA (
   ID_AREA              SERIAL not null,
   NAME_AREA            VARCHAR(40)          not null,
   DESCRIPTION_AREA     TEXT                 null,
   constraint PK_AREA primary key (ID_AREA)
);

/*==============================================================*/
/* Index: AREA_PK                                               */
/*==============================================================*/
create unique index AREA_PK on AREA (
ID_AREA
);

/*==============================================================*/
/* Table: ASSOCIATION                                           */
/*==============================================================*/
create table ASSOCIATION (
   ID_ASSOCIATION       SERIAL not null,
   ID_QUESTION          INT4                 not null,
   ID_ANSWER_ELEMENT    INT4                 not null,
   constraint PK_ASSOCIATION primary key (ID_ASSOCIATION)
);

/*==============================================================*/
/* Index: ASSOCIATION_PK                                        */
/*==============================================================*/
create unique index ASSOCIATION_PK on ASSOCIATION (
ID_ASSOCIATION
);

/*==============================================================*/
/* Index: RELATIONSHIP_13_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_13_FK on ASSOCIATION (
ID_QUESTION
);

/*==============================================================*/
/* Index: RELATIONSHIP_14_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_14_FK on ASSOCIATION (
ID_ANSWER_ELEMENT
);

/*==============================================================*/
/* Table: KEY_WORD                                              */
/*==============================================================*/
create table KEY_WORD (
   ID_KEY_WORD          SERIAL not null,
   ID_QUESTION          INT4                 not null,
   CONTENT_WORD         VARCHAR(40)          not null,
   constraint PK_KEY_WORD primary key (ID_KEY_WORD)
);

/*==============================================================*/
/* Index: KEY_WORD_PK                                           */
/*==============================================================*/
create unique index KEY_WORD_PK on KEY_WORD (
ID_KEY_WORD
);

/*==============================================================*/
/* Index: PUEDE_TENER_1_FK                                      */
/*==============================================================*/
create  index PUEDE_TENER_1_FK on KEY_WORD (
ID_QUESTION
);

/*==============================================================*/
/* Table: QUESTION                                              */
/*==============================================================*/
create table QUESTION (
   ID_QUESTION          SERIAL not null,
   ID_TYPE              INT4                 not null,
   ID_AREA              INT4                 not null,
   STATEMENT_QUESTION   TEXT                 not null,
   PATH_IMAGE_QUESTION  VARCHAR(256)         null,
   PATH_FILE_QUESTION   VARCHAR(256)         null,
   constraint PK_QUESTION primary key (ID_QUESTION)
);

/*==============================================================*/
/* Index: QUESTION_PK                                           */
/*==============================================================*/
create unique index QUESTION_PK on QUESTION (
ID_QUESTION
);

/*==============================================================*/
/* Index: PERTENECE_FK                                          */
/*==============================================================*/
create  index PERTENECE_FK on QUESTION (
ID_TYPE
);

/*==============================================================*/
/* Index: TIENE_12_FK                                           */
/*==============================================================*/
create  index TIENE_12_FK on QUESTION (
ID_AREA
);

/*==============================================================*/
/* Table: TEST                                                  */
/*==============================================================*/
create table TEST (
   ID_TEST              SERIAL not null,
   ID_USER              INT4                 not null,
   TITLE_TEST           VARCHAR(200)         not null,
   MATTER               VARCHAR(60)          not null,
   INSTITUTION          VARCHAR(150)         null,
   HOUR_INIT            DATE                 null,
   HOUR_END             DATE                 null,
   DATE                 DATE                 null,
   SCORE_TEST           DECIMAL(100,3)       null,
   TOTAL_PERCENTAGE     DECIMAL              null,
   TEST_PASSWORD        VARCHAR(20)          null,
   constraint PK_TEST primary key (ID_TEST)
);

/*==============================================================*/
/* Index: TEST_PK                                               */
/*==============================================================*/
create unique index TEST_PK on TEST (
ID_TEST
);

/*==============================================================*/
/* Index: CREAR_FK                                              */
/*==============================================================*/
create  index CREAR_FK on TEST (
ID_USER
);

/*==============================================================*/
/* Table: TEST_QUESTION                                         */
/*==============================================================*/
create table TEST_QUESTION (
   ID_QUESTION          INT4                 not null,
   ID_TEST              INT4                 null,
   PERCENT              INT4                 not null,
   constraint PK_TEST_QUESTION primary key (ID_QUESTION)
);

/*==============================================================*/
/* Index: TEST_CUESTION_PK                                      */
/*==============================================================*/
create unique index TEST_CUESTION_PK on TEST_QUESTION (
ID_QUESTION
);

/*==============================================================*/
/* Index: TIENE_1_FK                                            */
/*==============================================================*/
create  index TIENE_1_FK on TEST_QUESTION (
ID_TEST
);

/*==============================================================*/
/* Table: TEST_TAKEN                                            */
/*==============================================================*/
create table TEST_TAKEN (
   ID_TEST_TAKEN        SERIAL not null,
   ID_USER              INT4                 not null,
   ID_TEST              INT4                 not null,
   USER_SCORE           DECIMAL              null,
   constraint PK_TEST_TAKEN primary key (ID_TEST_TAKEN, ID_USER, ID_TEST)
);

/*==============================================================*/
/* Index: TEST_TAKEN_PK                                         */
/*==============================================================*/
create unique index TEST_TAKEN_PK on TEST_TAKEN (
ID_TEST_TAKEN,
ID_USER,
ID_TEST
);

/*==============================================================*/
/* Index: RESUELTO_FK                                           */
/*==============================================================*/
create  index RESUELTO_FK on TEST_TAKEN (
ID_TEST
);

/*==============================================================*/
/* Index: REALIZA_1_FK                                          */
/*==============================================================*/
create  index REALIZA_1_FK on TEST_TAKEN (
ID_USER
);

/*==============================================================*/
/* Table: TYPE_CUESTION                                         */
/*==============================================================*/
create table TYPE_CUESTION (
   ID_TYPE              SERIAL not null,
   NAME_TYPE            VARCHAR(30)          not null,
   constraint PK_TYPE_CUESTION primary key (ID_TYPE)
);

/*==============================================================*/
/* Index: TYPE_CUESTION_PK                                      */
/*==============================================================*/
create unique index TYPE_CUESTION_PK on TYPE_CUESTION (
ID_TYPE
);

/*==============================================================*/
/* Table: USER_ANSWER                                           */
/*==============================================================*/
create table USER_ANSWER (
   ID_USER_ANSWER       SERIAL not null,
   ID_TEST_TAKEN        INT4                 not null,
   ID_USER              INT4                 not null,
   ID_TEST              INT4                 not null,
   ID_QUESTION          INT4                 not null,
   RESPONSE             TEXT                 null,
   ORDER_ANSWER         VARCHAR(24)          null,
   constraint PK_USER_ANSWER primary key (ID_USER_ANSWER)
);

/*==============================================================*/
/* Index: USER_ANSWER_PK                                        */
/*==============================================================*/
create unique index USER_ANSWER_PK on USER_ANSWER (
ID_USER_ANSWER
);

/*==============================================================*/
/* Index: RESPONDIO_FK                                          */
/*==============================================================*/
create  index RESPONDIO_FK on USER_ANSWER (
ID_TEST_TAKEN,
ID_USER,
ID_TEST
);

/*==============================================================*/
/* Index: RELATIONSHIP_12_FK                                    */
/*==============================================================*/
create  index RELATIONSHIP_12_FK on USER_ANSWER (
ID_QUESTION
);

/*==============================================================*/
/* Table: USER_SYSTEM                                           */
/*==============================================================*/
create table USER_SYSTEM (
   ID_USER              SERIAL not null,
   LOGIN                VARCHAR(25)          not null,
   PASSWORD             VARCHAR(100)         not null,
   NAME                 CHAR(20)             not null,
   MAIL                 VARCHAR(200)         not null,
   LAST_NAME            CHAR(50)             null,
   constraint PK_USER_SYSTEM primary key (ID_USER)
);

/*==============================================================*/
/* Index: USER_PK                                               */
/*==============================================================*/
create unique index USER_PK on USER_SYSTEM (
ID_USER
);

alter table ANSWER_ELEMENT
   add constraint FK_ANSWER_E_PUEDE_TEN_QUESTION foreign key (ID_QUESTION)
      references QUESTION (ID_QUESTION)
      on delete restrict on update restrict;

alter table ASSOCIATION
   add constraint FK_ASSOCIAT_RELATIONS_QUESTION foreign key (ID_QUESTION)
      references QUESTION (ID_QUESTION)
      on delete restrict on update restrict;

alter table ASSOCIATION
   add constraint FK_ASSOCIAT_RELATIONS_ANSWER_E foreign key (ID_ANSWER_ELEMENT)
      references ANSWER_ELEMENT (ID_ANSWER_ELEMENT)
      on delete restrict on update restrict;

alter table KEY_WORD
   add constraint FK_KEY_WORD_PUEDE_TEN_QUESTION foreign key (ID_QUESTION)
      references QUESTION (ID_QUESTION)
      on delete restrict on update restrict;

alter table QUESTION
   add constraint FK_QUESTION_PERTENECE_TYPE_CUE foreign key (ID_TYPE)
      references TYPE_CUESTION (ID_TYPE)
      on delete restrict on update restrict;

alter table QUESTION
   add constraint FK_QUESTION_TIENE_12_AREA foreign key (ID_AREA)
      references AREA (ID_AREA)
      on delete restrict on update restrict;

alter table TEST
   add constraint FK_TEST_CREAR_USER_SYS foreign key (ID_USER)
      references USER_SYSTEM (ID_USER)
      on delete restrict on update restrict;

alter table TEST_QUESTION
   add constraint FK_TEST_QUE_ESTA_QUESTION foreign key (ID_QUESTION)
      references QUESTION (ID_QUESTION)
      on delete restrict on update restrict;

alter table TEST_QUESTION
   add constraint FK_TEST_QUE_TIENE_1_TEST foreign key (ID_TEST)
      references TEST (ID_TEST)
      on delete restrict on update restrict;

alter table TEST_TAKEN
   add constraint FK_TEST_TAK_REALIZA_1_USER_SYS foreign key (ID_USER)
      references USER_SYSTEM (ID_USER)
      on delete restrict on update restrict;

alter table TEST_TAKEN
   add constraint FK_TEST_TAK_RESUELTO_TEST foreign key (ID_TEST)
      references TEST (ID_TEST)
      on delete restrict on update restrict;

alter table USER_ANSWER
   add constraint FK_USER_ANS_RELATIONS_QUESTION foreign key (ID_QUESTION)
      references QUESTION (ID_QUESTION)
      on delete restrict on update restrict;

alter table USER_ANSWER
   add constraint FK_USER_ANS_RESPONDIO_TEST_TAK foreign key (ID_TEST_TAKEN, ID_USER, ID_TEST)
      references TEST_TAKEN (ID_TEST_TAKEN, ID_USER, ID_TEST)
      on delete restrict on update restrict;

