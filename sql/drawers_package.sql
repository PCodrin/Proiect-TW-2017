DROP PACKAGE drawers_package;
 CREATE OR REPLACE PACKAGE drawers_package IS
        PROCEDURE create_drawer(v_closet_id DRAWERS.CLOSET_ID%TYPE, v_drawer_name CLOSETS.NAME%TYPE,v_locked DRAWERS.LOCKED%TYPE,v_password DRAWERS.PASSWORD%TYPE, v_output out integer );
        PROCEDURE edit_drawer_name(v_drawer_id DRAWERS.ID%TYPE,v_drawer_name DRAWERS.NAME%TYPE,v_output out integer);    
        PROCEDURE edit_drawer_password(v_drawer_id DRAWERS.ID%TYPE,v_new_password DRAWERS.PASSWORD%TYPE,v_old_password DRAWERS.PASSWORD%TYPE,v_output out integer);
        PROCEDURE make_drawer_locked(v_drawer_id DRAWERS.ID%TYPE,v_password DRAWERS.PASSWORD%TYPE);
        PROCEDURE make_drawer_unlocked(v_drawer_id DRAWERS.ID%TYPE,v_password DRAWERS.PASSWORD%TYPE,v_output out integer);
        PROCEDURE delete_drawer(v_drawer_id DRAWERS.ID%TYPE);
 END drawers_package;   
      
DROP PACKAGE BODY drawers_package;
CREATE OR REPLACE PACKAGE BODY drawers_package IS

        --CREATE DRAWER
        
        PROCEDURE create_drawer(v_closet_id DRAWERS.CLOSET_ID%TYPE, v_drawer_name CLOSETS.NAME%TYPE,v_locked DRAWERS.LOCKED%TYPE,v_password DRAWERS.PASSWORD%TYPE, v_output out integer )
        AS
        v_capat1 integer:=0;
        v_capat2 integer:=0;
        v_name DRAWERS.NAME%TYPE;
        v_creation_date DRAWERS.CREATION_DATE%TYPE;
        v_id DRAWERS.ID%TYPE:=0;
        BEGIN
            v_output:=0;
            select count(id) into v_capat1 from DRAWERS;
            IF(v_capat1=0)THEN
                  select SYSDATE into v_creation_date from Dual;
                  v_id:=v_id+1;
                    IF(v_locked=0)THEN
                        INSERT INTO DRAWERS
                          (id,name,closet_id,creation_date)
                        VALUES
                          (v_id,v_drawer_name,v_closet_id,v_creation_date);
                    ELSE
                        INSERT INTO DRAWERS
                          (id,name,closet_id,creation_date,locked,password)
                        VALUES
                          (v_id,v_drawer_name,v_closet_id,v_creation_date,v_locked,v_password);
                    END IF;
            ELSE
              select count(id) into v_capat2 from DRAWERS where closet_id=v_closet_id;
              FOR v_contor in 1..v_capat2 LOOP
                    select name into v_name from (select * from  (select * from (select id, name from drawers where closet_id=v_closet_id) where rownum <=v_contor) ORDER BY ID DESC) where rownum<=1;
                     IF(v_name like v_drawer_name)THEN
                        v_output:=-1;
                     END IF;
                    IF(v_output!=0)THEN
                      GOTO eticheta; 
                    END IF;
              END LOOP;
              <<eticheta>>
                 IF(v_output=0)THEN
                    select SYSDATE into v_creation_date from Dual;
                    select id into v_id from (select * from  (select * from (select id  from drawers) where rownum <=v_capat1) ORDER BY ID DESC) where rownum<=1;
                    v_id:=v_id+1;
                    v_output:=v_id;
                    IF(v_locked=0)THEN
                        INSERT INTO DRAWERS
                          (id,name,closet_id,creation_date)
                        VALUES
                          (v_id,v_drawer_name,v_closet_id,v_creation_date);
                    ELSE
                        INSERT INTO DRAWERS
                          (id,name,closet_id,creation_date,locked,password)
                        VALUES
                          (v_id,v_drawer_name,v_closet_id,v_creation_date,v_locked,v_password);
                    END IF;
                 END IF;
            END IF;
        END create_drawer;
        
        --EDIT DRAWER NAME
        
        PROCEDURE edit_drawer_name(v_drawer_id DRAWERS.ID%TYPE,v_drawer_name DRAWERS.NAME%TYPE,v_output out integer) 
        AS
        
        v_capat integer:=0;
        v_name DRAWERS.NAME%TYPE;
        v_closet_id DRAWERS.CLOSET_ID%TYPE;
        
        BEGIN
            select closet_id into v_closet_id from drawers where id=v_drawer_id;
            v_output:=0;      
            select count(id) into v_capat from drawers where closet_id=v_closet_id;
              FOR v_contor in 1..v_capat LOOP
                    select name into v_name from (select * from  (select * from (select id, name from drawers where closet_id=v_closet_id) where rownum <=v_contor) ORDER BY ID DESC) where rownum<=1;
                     IF(v_name like v_drawer_name)THEN
                        v_output:=-1;
                     END IF;
                    IF(v_output!=0)THEN
                      GOTO eticheta; 
                    END IF;
              END LOOP;
              <<eticheta>>
                 IF(v_output=0)THEN
                    
                    UPDATE DRAWERS
                    SET name=v_drawer_name
                    WHERE id=v_drawer_id;
                END IF;
         END edit_drawer_name;
         
         --EDIT DRAWER PASSWORD
         
         PROCEDURE edit_drawer_password(v_drawer_id DRAWERS.ID%TYPE,v_new_password DRAWERS.PASSWORD%TYPE,v_old_password DRAWERS.PASSWORD%TYPE,v_output out integer)
         AS
         v_password DRAWERS.PASSWORD%TYPE;
         BEGIN
              v_output:=0;
              SELECT password into v_password from drawers where id=v_drawer_id;
              IF(v_password like v_old_password)THEN
                  UPDATE DRAWERS
                  SET password=v_new_password
                  WHERE id=v_drawer_id;
              ELSE
                  v_output:=-1;
              END IF;
         END edit_drawer_password;
         
         --MAKE_DRAWER_LOCKED
         
         PROCEDURE make_drawer_locked(v_drawer_id DRAWERS.ID%TYPE,v_password DRAWERS.PASSWORD%TYPE)
         AS
        
         BEGIN
              UPDATE DRAWERS
                  SET password=v_password,
                      locked=1
                  WHERE id=v_drawer_id;
         END make_drawer_locked;
         
          --MAKE_DRAWER_UNLOCKED
         
         PROCEDURE make_drawer_unlocked(v_drawer_id DRAWERS.ID%TYPE,v_password DRAWERS.PASSWORD%TYPE,v_output out integer)
         AS
         v_password_drawer DRAWERS.PASSWORD%TYPE;
         BEGIN
              select password into v_password_drawer from drawers where id=v_drawer_id;
              IF(v_password_drawer LIKE v_password)THEN
                  v_output:=0;
                  UPDATE DRAWERS
                  SET password=NULL,
                      locked=0
                  WHERE id=v_drawer_id;
              ELSE
                  v_output:=-1;
              END IF;
         END make_drawer_unlocked;
         
         --DELETE DRAWER
        PROCEDURE delete_drawer(v_drawer_id DRAWERS.ID%TYPE)
        AS
        BEGIN
              
              DELETE FROM DRAWERS
              WHERE v_drawer_id=id;
                
        END delete_drawer;
         
         
                                    
END drawers_package;





set serveroutput on;
DECLARE
v_output integer:=0;
BEGIN
     drawers_package.create_drawer(2,'sertar4',1,'0000', v_output);
     if(v_output=-1)THEN
     dbms_output.put_line('GRESIT');
     else 
          dbms_output.put_line('OK');
          
    END if;

END;

set serveroutput on;
DECLARE
v_output integer:=0;
BEGIN
     drawers_package.delete_drawer(11);
     if(v_output=-1)THEN
     dbms_output.put_line('GRESIT');
     else 
          dbms_output.put_line('OK');
          
    END if;

END;




