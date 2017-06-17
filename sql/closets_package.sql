DROP PACKAGE closets_package;
 CREATE OR REPLACE PACKAGE closets_package IS
        PROCEDURE create_closet(v_user_id CLOSETS.USER_ID%TYPE, v_closet_name CLOSETS.NAME%TYPE, v_output out integer );
        PROCEDURE edit_closet(v_id CLOSETS.ID%TYPE, v_closet_name  CLOSETS.NAME%TYPE,v_output out integer);
        PROCEDURE delete_closet(v_id CLOSETS.ID%TYPE);
END closets_package;   
      
DROP PACKAGE BODY closets_package;
CREATE OR REPLACE PACKAGE BODY closets_package IS

        --CREATE CLOSET
        
        PROCEDURE create_closet(v_user_id CLOSETS.USER_ID%TYPE, v_closet_name CLOSETS.NAME%TYPE, v_output out integer )
        AS
        v_capat1 integer:=0;
        v_capat2 integer:=0;
        v_name CLOSETS.NAME%TYPE;
        v_creation_date CLOSETS.CREATION_DATE%TYPE;
        v_id CLOSETS.ID%TYPE:=0;
        BEGIN
            v_output:=0;
            select count(id) into v_capat1 from Closets;
            IF(v_capat1=0)THEN
                  select SYSDATE into v_creation_date from Dual;
                  v_id:=v_id+1;
                  v_output:=1;
                    INSERT INTO CLOSETS   
                       (id,name,user_id,creation_date)
                    VALUES
                       (v_id,v_closet_name,v_user_id,v_creation_date);
            ELSE
              select count(id) into v_capat2 from Closets where user_id=v_user_id;
              FOR v_contor in 1..v_capat2 LOOP
                    select name into v_name from (select * from  (select * from (select id, name from closets where user_id=v_user_id) where rownum <=v_contor) ORDER BY ID DESC) where rownum<=1;
                     IF(v_name like v_closet_name)THEN
                        v_output:=-1;
                     END IF;
                    IF(v_output!=0)THEN
                      GOTO eticheta; 
                    END IF;
              END LOOP;
              <<eticheta>>
                 IF(v_output=0)THEN
                    select SYSDATE into v_creation_date from Dual;
                    select id into v_id from (select * from  (select * from (select id  from closets) where rownum <=v_capat1) ORDER BY ID DESC) where rownum<=1;
                    v_id:=v_id+1;
                    v_output:=v_id;
                    INSERT INTO CLOSETS
                       (id,name,user_id,creation_date)
                    VALUES
                       (v_id,v_closet_name,v_user_id,v_creation_date);
                END IF;
            END IF;
        END create_closet;
        
        --EDIT CLOSET
        
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
                        v_output:=-1;
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
               
        END edit_closet;
        
        
        --DELETE CLOSET
        PROCEDURE delete_closet(v_id CLOSETS.ID%TYPE)
        AS
        BEGIN
              
              DELETE FROM CLOSETS
              WHERE v_id=id;
                
        END delete_closet;
                              
END closets_package;

