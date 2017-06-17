DROP PACKAGE objects_package;
 CREATE OR REPLACE PACKAGE objects_package IS
         PROCEDURE create_object(v_drawer_id OBJECTS.DRAWER_ID%TYPE, v_object_name OBJECTS.NAME%TYPE,v_property_name PROPERTIES.PROPERTY_NAME%TYPE,v_property_value PROPERTIES.PROPERTY_value%TYPE);
         PROCEDURE move_object(v_object_id OBJECTS.ID%TYPE,v_drawer_id OBJECTS.DRAWER_ID%TYPE);
         PROCEDURE edit_object_name(v_object_id OBJECTS.ID%TYPE,v_object_name OBJECTS.NAME%TYPE);
         PROCEDURE delete_object(v_object_id OBJECTS.ID%TYPE);
 END objects_package;   
      
DROP PACKAGE BODY objects_package;
CREATE OR REPLACE PACKAGE BODY objects_package IS

        --CREATE OBJECT
        
        PROCEDURE create_object(v_drawer_id OBJECTS.DRAWER_ID%TYPE, v_object_name OBJECTS.NAME%TYPE,v_property_name PROPERTIES.PROPERTY_NAME%TYPE,v_property_value PROPERTIES.PROPERTY_value%TYPE)
        AS
        v_capat integer:=0;
        v_creation_date DRAWERS.CREATION_DATE%TYPE;
        v_id OBJECTS.ID%TYPE:=0;
        BEGIN
            
            select count(id) into v_capat from OBJECTS;
            IF(v_capat=0)THEN
               v_id:=1;
            ELSE
               select id into v_id from (select * from  (select * from (select id  from objects) where rownum <=v_capat) ORDER BY ID DESC) where rownum<=1;
               v_id:=v_id+1;
            END IF;
            select SYSDATE into v_creation_date from Dual;
                INSERT INTO OBJECTS
                     (id,name,drawer_id,added_date,creation_date)
                VALUES
                     (v_id,v_object_name,v_drawer_id,v_creation_date,v_creation_date);
                     properties_package.add_property(v_id,v_property_name,v_property_value);
                    
         END create_object;
         
         --EDIT OBJECT NAME
                
               
         PROCEDURE edit_object_name(v_object_id OBJECTS.ID%TYPE,v_object_name OBJECTS.NAME%TYPE) 
         AS
         
         BEGIN
              UPDATE OBJECTS  
              SET name=v_object_name
              WHERE id=v_object_id;
         END;
                
         --MOVE OBJECT
         
         PROCEDURE move_object(v_object_id OBJECTS.ID%TYPE,v_drawer_id OBJECTS.DRAWER_ID%TYPE)
         AS
         v_added_date OBJECTS.ADDED_DATE%TYPE;
         BEGIN
              select SYSDATE into v_added_date from Dual;
              UPDATE OBJECTS
               SET drawer_id=v_drawer_id,
                   added_date=v_added_date
               WHERE id=v_object_id;
         END move_object;
         
        --DELETE OBJECT
        
        PROCEDURE delete_object(v_object_id OBJECTS.ID%TYPE)
        AS
        BEGIN
              
              DELETE FROM OBJECTS
              WHERE v_object_id=id;
                
        END delete_object;
        
                             
END objects_package;




