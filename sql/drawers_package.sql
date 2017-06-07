DROP PACKAGE drawers_package;
 CREATE OR REPLACE PACKAGE drawers_package IS
        PROCEDURE create_drawer(v_closet_id DRAWERS.CLOSET_ID%TYPE, v_drawer_name CLOSETS.NAME%TYPE,v_locked DRAWERS.LOCKED%TYPE,v_password DRAWERS.PASSWORD%TYPE, v_output out integer );
      --  PROCEDURE edit_drawer(v_id CLOSETS.ID%TYPE, v_closet_name  CLOSETS.NAME%TYPE,v_output out integer);   
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
        
       /* --EDIT CLOSET
        
        PROCEDURE edit_closet(v_id CLOSETS.ID%TYPE, v_closet_name  CLOSETS.NAME%TYPE,v_output out integer)
        AS
        
        v_capat2 integer:=0;
        v_name CLOSETS.NAME%TYPE;
        v_user_id CLOSETS.USER_ID%TYPE;
        
        BEGIN
            select user_id into v_user_id from closets where id=v_id;
            v_output:=0;      
            select count(id) into v_capat2 from Closets where user_id=v_user_id;
              FOR v_contor in 1..v_capat2 LOOP
                    select name into v_name from (select * from  (select * from (select id, name from closets where user_id=v_user_id) where rownum <=v_contor) ORDER BY ID DESC) where rownum<=1;
                     IF(v_name like v_closet_name)THEN
                        v_output:=1;
                     END IF;
                    IF(v_output!=0)THEN
                      GOTO eticheta; 
                    END IF;
              END LOOP;
              <<eticheta>>
                 IF(v_output=0)THEN
                    
                    UPDATE CLOSETS
                    SET name=v_closet_name
                    WHERE id=v_id;
                END IF;
               
        END edit_closet;*/
                              
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