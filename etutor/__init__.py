import pymysql
def mysqldb_escape(value, conv_dict):
    from pymysql.converters import encoders
    vtype = type(value)
    encoder = encoders.get(vtype)
    return encoder(value)
setattr(pymysql, 'escape', mysqldb_escape)
pymysql.install_as_MySQLdb()
