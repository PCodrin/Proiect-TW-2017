DROP PACKAGE users_tw;
 CREATE OR REPLACE PACKAGE users_tw IS
        PROCEDURE login(v_username USERS.USERNAME%TYPE, v_password USERS.PASSWORD%TYPE, v_output out integer );
        PROCEDURE register_user(v_username USERS.USERNAME%TYPE, v_firstname USERS.FIRSTNAME%TYPE, v_lastname USERS.LASTNAME%TYPE, v_e_mail USERS.E_MAIL%TYPE, v_password USERS.PASSWORD%TYPE,v_output out number);
        /*PROCEDURE delete_user(v_id USERS.ID%TYPE);
        PROCEDURE update_user(v_id USERS.ID%TYPE, v_firstname  USERS.FIRSTNAME%TYPE, v_lastname  USERS.LASTNAME%TYPE, v_admin  USERS.ADMIN%TYPE);
        */
END users_tw;   
      
DROP PACKAGE BODY users_tw;
CREATE OR REPLACE PACKAGE BODY users_tw IS

        --LOGIN
        
        PROCEDURE login(v_username USERS.USERNAME%TYPE, v_password USERS.PASSWORD%TYPE, v_output out integer )
        AS
        v_password1 USERS.PASSWORD%TYPE;
        v_id USERS.ID%TYPE;
        BEGIN
             select password, id into v_password1, v_id from users where v_username like username;
             if( v_password like v_password1) then
                 v_output:=v_id;
             else
                 v_output:=-1;
             end if;    
                  
            EXCEPTION
                 WHEN no_data_found THEN
                 v_output:=-1;
            
        END login;
        
        --REGISTER
        
        PROCEDURE register_user(v_username USERS.USERNAME%TYPE, v_firstname USERS.FIRSTNAME%TYPE, v_lastname USERS.LASTNAME%TYPE, v_e_mail USERS.E_MAIL%TYPE, v_password USERS.PASSWORD%TYPE, v_output out number)
        AS
        v_capat number:=0;
        v_id USERS.ID%TYPE:=0;
        v_creation_date USERS.CREATION_DATE%TYPE;
        v_username_tabela USERS.USERNAME%TYPE;
        v_e_mail_tabela USERS.E_MAIL%TYPE;
       
        BEGIN
             v_output:=0;
             select count(id) into v_capat from Users;
             IF(v_capat=0)THEN
                  select SYSDATE into v_creation_date from Dual;
                  v_id:=v_id+1;
                  INSERT INTO Users 
                      (id,username,password,firstname,lastname,e_mail,creation_date)
                  VALUES
                      (v_id,v_username,v_password,v_firstname,v_lastname,v_e_mail,v_creation_date);
             ELSE
                FOR v_contor in 1..v_capat LOOP
                   select username, e_mail into v_username_tabela, v_e_mail_tabela from (select * from  (select * from (select id , username, e_mail from users) where rownum <=v_contor) ORDER BY ID DESC) where rownum<=1;
                   IF(v_username like v_username_tabela)THEN
                        v_output:=1;
                   ELSIF(v_e_mail like v_e_mail_tabela)THEN
                        v_output:=2;
                   END IF;
                   IF(v_output!=0)THEN
                      GOTO eticheta;
                   END IF;
               END LOOP;
               <<eticheta>>
                IF(v_output=0)THEN
                  select SYSDATE into v_creation_date from Dual;
                  select id into v_id from (select * from  (select * from (select id  from users) where rownum <=v_capat) ORDER BY ID DESC) where rownum<=1;
                  v_id:=v_id+1;
                  INSERT INTO Users 
                      (id,username,password,firstname,lastname,e_mail,creation_date)
                  VALUES
                      (v_id,v_username,v_password,v_firstname,v_lastname,v_e_mail,v_creation_date);
                END IF;
             END IF;
             
             
             
        END register_user;
        
     /*   --DELETE USER
        PROCEDURE delete_user(v_id USERS.ID%TYPE)
        AS
        
        BEGIN
              
              DELETE FROM USERS
              WHERE v_id=id;
                
         
        END delete_user;
        
        --UPDATE USER
        
        PROCEDURE update_user(v_id USERS.ID%TYPE, v_firstname  USERS.FIRSTNAME%TYPE, v_lastname  USERS.LASTNAME%TYPE, v_admin  USERS.ADMIN%TYPE)
        AS
      
        BEGIN
             
                    UPDATE USERS
                    SET firstname= v_firstname,
                        lastname = v_lastname,
                           admin = v_admin
                    WHERE id=v_id;
              
               
        END update_user;
        
        */
            
END users_tw;
