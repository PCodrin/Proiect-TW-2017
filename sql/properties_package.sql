DROP PACKAGE properties_package;
 CREATE OR REPLACE PACKAGE properties_package IS
        PROCEDURE add_property(v_object_id PROPERTIES.OBJECT_ID%TYPE, v_property_name PROPERTIES.PROPERTY_NAME%TYPE,v_property_value PROPERTIES.PROPERTY_value%TYPE);
         
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
         
        --EDIT PROPERTY
         
                        
END properties_package;



set serveroutput on;
DECLARE
v_output integer:=0;
BEGIN
     properties_package.add_property(2,'culoare','verde');
     if(v_output=-1)THEN
     dbms_output.put_line('GRESIT');
     else 
          dbms_output.put_line('OK');
          
    END if;

END;
