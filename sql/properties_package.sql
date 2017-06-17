DROP PACKAGE properties_package;
 CREATE OR REPLACE PACKAGE properties_package IS
        PROCEDURE add_property(v_object_id PROPERTIES.OBJECT_ID%TYPE, v_property_name PROPERTIES.PROPERTY_NAME%TYPE,v_property_value PROPERTIES.PROPERTY_value%TYPE);
        PROCEDURE edit_property_name(v_property_id PROPERTIES.ID%TYPE,v_property_name PROPERTIES.PROPERTY_NAME%TYPE); 
        PROCEDURE edit_property_value(v_property_id PROPERTIES.ID%TYPE,v_property_value PROPERTIES.PROPERTY_VALUE%TYPE);
        PROCEDURE delete_property(v_property_id PROPERTIES.ID%TYPE);
 END properties_package;   
      
DROP PACKAGE BODY properties_package;
CREATE OR REPLACE PACKAGE BODY properties_package IS

        --ADD PROPERTY
        
        PROCEDURE add_property(v_object_id PROPERTIES.OBJECT_ID%TYPE, v_property_name PROPERTIES.PROPERTY_NAME%TYPE,v_property_value PROPERTIES.PROPERTY_value%TYPE)
        AS
        v_capat integer:=0;
        v_id PROPERTIES.ID%TYPE:=0;
        BEGIN
            
            select count(id) into v_capat from PROPERTIES;
            IF(v_capat=0)THEN
               v_id:=1;
            ELSE
               select id into v_id from (select * from  (select * from (select id  from properties) where rownum <=v_capat) ORDER BY ID DESC) where rownum<=1;
               v_id:=v_id+1;
            END IF;
                INSERT INTO PROPERTIES
                     (id,object_id,property_name,property_value)
                VALUES
                     (v_id,v_object_id,v_property_name,v_property_value);
         END add_property;
         
        --EDIT PROPERTY NAME
         
         PROCEDURE edit_property_name(v_property_id PROPERTIES.ID%TYPE,v_property_name PROPERTIES.PROPERTY_NAME%TYPE)
         AS
         
         BEGIN
              UPDATE PROPERTIES  
              SET property_name=v_property_name
              WHERE id=v_property_id;
         END;
         
         --EDIT PROPERTY VALUE
         
         PROCEDURE edit_property_value(v_property_id PROPERTIES.ID%TYPE,v_property_value PROPERTIES.PROPERTY_VALUE%TYPE)
         AS
         
         BEGIN
              UPDATE PROPERTIES  
              SET property_value=v_property_value
              WHERE id=v_property_id;
         END;
         
        --DELETE PROPERTY
         
        PROCEDURE delete_property(v_property_id PROPERTIES.ID%TYPE)
        AS
        BEGIN
              
              DELETE FROM PROPERTIES
              WHERE v_property_id=id;
                
        END delete_property;
                        
END properties_package;



set serveroutput on;
DECLARE

BEGIN
     properties_package.delete_property(1);
    
          


END;
