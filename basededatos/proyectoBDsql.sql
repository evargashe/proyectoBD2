

create database proyectoBD;
use proyectoBD;

create table persona(
	dni integer primary key,
	nombre varchar(50) not null,
	primer_apellido varchar(15) not null,
	passW varchar(20) not null
);


create table correo_electronico(
	dni integer,
	correo_electronico varchar(40) not null,
	primary key(dni,correo_electronico)
);

create table telefono(
	dni integer,
	telefono varchar(40) not null,
	primary key(dni,telefono)
);


create table tienda(
	id_tienda integer primary key,
	nombre varchar(30) not null
);

create table factura(
	num_factura integer primary key,
	monto integer not null,
	id_sucursal integer
);

create table producto(
	cod_producto integer primary key,
	nombre varchar(50) not null,
	precio integer not null,
	stock integer not null,
	foto text not null,
	dni_empleado_administrador integer not null,
	num_factura integer not null
);

create table reserva(
	dni_cliente integer,
	cod_producto integer,
	fecha date not null,
	cantidad integer not null,
	monto integer,
	primary key(dni_cliente,cod_producto)
);

create table sucursal(
	id_sucursal integer primary key,
	nombre_cuida varchar(30) not null,
	nombre_distrito varchar(30) not null,
	id_tienda integer,
);

create table empleado(
	dni_empleado integer primary key,
	sueldo integer,
	horario time,
	id_sucursal integer
);

create table cliente(
	dni_cliente integer primary key,
	credito integer not null,
	id_sucursal integer
);

create table cajero(
	dni_empleado_cajero integer primary key
);

create table administrador(
	dni_empleado_administrador integer primary key
);

create table vales(
	num_vale integer primary key,
	monto integer,
	descripcion varchar(50),
	dni_empleado integer
);


alter table correo_electronico add foreign key(dni) references persona(dni);
alter table telefono add foreign key(dni) references persona(dni);

alter table empleado add foreign key(dni_empleado) references persona(dni);
alter table cliente add foreign key(dni_cliente) references persona(dni);

alter table cajero add foreign key(dni_empleado_cajero) references empleado(dni_empleado);
alter table administrador add foreign key(dni_empleado_administrador) references empleado(dni_empleado);

alter table vales add foreign key(dni_empleado) references empleado(dni_empleado);

alter table empleado add foreign key(id_sucursal) references sucursal(id_sucursal);
alter table cliente add foreign key(id_sucursal) references sucursal(id_sucursal);

alter table sucursal add foreign key(id_tienda) references tienda(id_tienda);

alter table factura add foreign key(id_sucursal) references sucursal(id_sucursal); 

alter table reserva add foreign key(dni_cliente) references cliente(dni_cliente);
alter table reserva add foreign key(cod_producto) references producto(cod_producto);

alter table producto add foreign key(dni_empleado_administrador) references administrador(dni_empleado_administrador);
alter table producto add foreign key(num_factura) references factura(num_factura);



