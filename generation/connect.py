import mysql.connector
from mysql.connector import Error

def create_connection(host_name,user_name,user_password,database_name):
    connection = None
    try:
        connection = mysql.connector.connect(
            host=host_name,
            user=user_name,
            passwd=user_password,
            database=database_name
        )
        print("МЫЫЫЫ ПОДКЛЮЧИСЬ")
    except Error as e:
        print(f"The error '{e}' occurred")
    return connection

connection = create_connection('localserver', 'root', 'phpkek228','tkuik')

def execute_query(connection, query):
    cursor = connection.cursor()
    try:
        cursor.execute(query)
        connection.commit()
    except Error as e:
        Error_text = f'{e}'
        if '1062 (23000): Duplicate entry' in Error_text:
            print('СТУДЕНТ ДОБАВЛЕН!')
        else:
           print(f"The error '{e}' occurred")
           
def execute_read_query(connection, query):
    cursor = connection.cursor(buffered=True)
    result = None
    try:
        cursor.execute(query)
        result = cursor.fetchall()
        return result
    except Error as e:
        print(f"The error '{e}' occurred")
