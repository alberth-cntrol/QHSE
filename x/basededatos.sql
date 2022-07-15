SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `albalinea`
-- 

CREATE TABLE `albalinea` (
  `codalbaran` int(11) NOT NULL default '0',
  `numlinea` int(4) NOT NULL auto_increment,
  `codfamilia` int(3) default NULL,
  `codigo` varchar(15) character set utf8 default NULL,
  `cantidad` float NOT NULL default '0',
  `precio` float NOT NULL default '0',
  `importe` float NOT NULL default '0',
  `dcto` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`codalbaran`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `albalineap`
-- 

CREATE TABLE `albalineap` (
  `codalbaran` varchar(20) NOT NULL default '0',
  `codproveedor` int(5) NOT NULL default '0',
  `numlinea` int(4) NOT NULL auto_increment,
  `codfamilia` int(3) default NULL,
  `codigo` varchar(15) default NULL,
  `cantidad` float NOT NULL default '0',
  `precio` float NOT NULL default '0',
  `importe` float NOT NULL default '0',
  `dcto` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`codalbaran`,`codproveedor`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `albalineaptmp`
-- 

CREATE TABLE `albalineaptmp` (
  `codalbaran` int(11) NOT NULL default '0',
  `numlinea` int(4) NOT NULL auto_increment,
  `codfamilia` int(3) default NULL,
  `codigo` varchar(15) default NULL,
  `cantidad` float NOT NULL default '0',
  `precio` float NOT NULL default '0',
  `importe` float NOT NULL default '0',
  `dcto` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`codalbaran`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `albalineatmp`
-- 

CREATE TABLE `albalineatmp` (
  `codalbaran` int(11) NOT NULL default '0',
  `numlinea` int(4) NOT NULL auto_increment,
  `codfamilia` int(3) default NULL,
  `codigo` varchar(15) character set utf8 default NULL,
  `cantidad` float NOT NULL default '0',
  `precio` float NOT NULL default '0',
  `importe` float NOT NULL default '0',
  `dcto` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`codalbaran`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `albaranes`
-- 

CREATE TABLE `albaranes` (
  `codalbaran` int(11) NOT NULL auto_increment,
  `codfactura` int(11) NOT NULL default '0',
  `fecha` date NOT NULL default '0000-00-00',
  `iva` tinyint(4) NOT NULL default '0',
  `codcliente` int(5) default '0',
  `estado` varchar(1) character set utf8 default '1',
  `totalalbaran` float NOT NULL,
  `borrado` varchar(1) NOT NULL default '0',
  PRIMARY KEY  (`codalbaran`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `albaranesp`
-- 

CREATE TABLE `albaranesp` (
  `codalbaran` varchar(20) NOT NULL default '0',
  `codproveedor` int(5) NOT NULL default '0',
  `codfactura` varchar(20) default NULL,
  `fecha` date NOT NULL default '0000-00-00',
  `iva` tinyint(4) NOT NULL default '0',
  `estado` varchar(1) default '1',
  `totalalbaran` float NOT NULL default '0',
  PRIMARY KEY  (`codalbaran`,`codproveedor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `albaranesptmp`
-- 

CREATE TABLE `albaranesptmp` (
  `codalbaran` int(11) NOT NULL auto_increment,
  `fecha` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`codalbaran`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Temporal de albaranes de proveedores para controlar acceso s' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `albaranestmp`
-- 

CREATE TABLE `albaranestmp` (
  `codalbaran` int(11) NOT NULL auto_increment,
  `fecha` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`codalbaran`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Temporal de albaranes para controlar acceso simultaneo' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `articulos`
-- 

CREATE TABLE `articulos` (
  `codarticulo` int(10) NOT NULL auto_increment,
  `codfamilia` int(5) NOT NULL,
  `referencia` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  `impuesto` float NOT NULL,
  `codproveedor1` int(5) NOT NULL default '1',
  `codproveedor2` int(5) NOT NULL,
  `descripcion_corta` varchar(30) NOT NULL,
  `codubicacion` int(3) NOT NULL,
  `stock` int(10) NOT NULL,
  `stock_minimo` int(8) NOT NULL,
  `aviso_minimo` varchar(1) NOT NULL default '0',
  `datos_producto` varchar(200) NOT NULL,
  `fecha_alta` date NOT NULL default '0000-00-00',
  `codembalaje` int(3) NOT NULL,
  `unidades_caja` int(8) NOT NULL,
  `precio_ticket` varchar(1) NOT NULL default '0',
  `modificar_ticket` varchar(1) NOT NULL default '0',
  `observaciones` text NOT NULL,
  `precio_compra` float(10,2) default NULL,
  `precio_almacen` float(10,2) default NULL,
  `precio_tienda` float(10,2) default NULL,
  `precio_pvp` float(10,2) default NULL,
  `precio_iva` float(10,2) default NULL,
  `codigobarras` varchar(15) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `borrado` varchar(1) NOT NULL default '0',
  PRIMARY KEY  (`codarticulo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Articulos' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `artpro`
-- 

CREATE TABLE `artpro` (
  `codarticulo` varchar(15) NOT NULL,
  `codfamilia` int(3) NOT NULL,
  `codproveedor` int(5) NOT NULL,
  `precio` float NOT NULL,
  PRIMARY KEY  (`codarticulo`,`codfamilia`,`codproveedor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `clientes`
-- 

CREATE TABLE `clientes` (
  `codcliente` int(5) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  `nif` varchar(12) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `codprovincia` int(2) NOT NULL default '0',
  `localidad` varchar(35) NOT NULL,
  `codformapago` int(2) NOT NULL default '0',
  `codentidad` int(2) NOT NULL default '0',
  `cuentabancaria` varchar(20) NOT NULL,
  `codpostal` varchar(5) NOT NULL,
  `telefono` varchar(14) NOT NULL,
  `movil` varchar(14) NOT NULL,
  `email` varchar(35) NOT NULL,
  `web` varchar(45) NOT NULL,
  `borrado` varchar(1) NOT NULL default '0',
  PRIMARY KEY  (`codcliente`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Clientes' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cobros`
-- 

CREATE TABLE `cobros` (
  `id` int(11) NOT NULL auto_increment,
  `codfactura` int(11) NOT NULL,
  `codcliente` int(5) NOT NULL,
  `importe` float NOT NULL,
  `codformapago` int(2) NOT NULL,
  `numdocumento` varchar(30) NOT NULL,
  `fechacobro` date NOT NULL default '0000-00-00',
  `observaciones` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Cobros de facturas a clientes' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `embalajes`
-- 

CREATE TABLE `embalajes` (
  `codembalaje` int(3) NOT NULL auto_increment,
  `nombre` varchar(30) default NULL,
  `borrado` varchar(1) NOT NULL default '0',
  PRIMARY KEY  (`codembalaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Embalajes' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `entidades`
-- 

CREATE TABLE `entidades` (
  `codentidad` int(2) NOT NULL auto_increment,
  `nombreentidad` varchar(50) NOT NULL,
  `borrado` varchar(1) NOT NULL default '0',
  PRIMARY KEY  (`codentidad`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Entidades Bancarias' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `factulinea`
-- 

CREATE TABLE `factulinea` (
  `codfactura` int(11) NOT NULL,
  `numlinea` int(4) NOT NULL auto_increment,
  `codfamilia` int(3) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `cantidad` float NOT NULL,
  `precio` float NOT NULL,
  `importe` float NOT NULL,
  `dcto` tinyint(4) NOT NULL,
  PRIMARY KEY  (`codfactura`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lineas de facturas a clientes' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `factulineap`
-- 

CREATE TABLE `factulineap` (
  `codfactura` varchar(20) NOT NULL default '',
  `codproveedor` int(5) NOT NULL,
  `numlinea` int(4) NOT NULL auto_increment,
  `codfamilia` int(3) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `cantidad` float NOT NULL,
  `precio` float NOT NULL,
  `importe` float NOT NULL,
  `dcto` tinyint(4) NOT NULL,
  PRIMARY KEY  (`codfactura`,`codproveedor`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lineas de facturas de proveedores' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `factulineaptmp`
-- 

CREATE TABLE `factulineaptmp` (
  `codfactura` int(11) NOT NULL,
  `numlinea` int(4) NOT NULL auto_increment,
  `codfamilia` int(3) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `cantidad` float NOT NULL,
  `precio` float NOT NULL,
  `importe` float NOT NULL,
  `dcto` tinyint(4) NOT NULL,
  PRIMARY KEY  (`codfactura`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='lineas de facturas de proveedores temporal' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `factulineatmp`
-- 

CREATE TABLE `factulineatmp` (
  `codfactura` int(11) NOT NULL,
  `numlinea` int(4) NOT NULL auto_increment,
  `codfamilia` int(3) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `cantidad` float NOT NULL,
  `precio` float NOT NULL,
  `importe` float NOT NULL,
  `dcto` tinyint(4) NOT NULL,
  PRIMARY KEY  (`codfactura`,`numlinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Temporal de linea de facturas a clientes' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `facturas`
-- 

CREATE TABLE `facturas` (
  `codfactura` int(11) NOT NULL auto_increment,
  `fecha` date NOT NULL,
  `iva` tinyint(4) NOT NULL,
  `codcliente` int(5) NOT NULL,
  `estado` varchar(1) NOT NULL default '0',
  `totalfactura` float NOT NULL,
  `fechavencimiento` date NOT NULL default '0000-00-00',
  `borrado` varchar(1) NOT NULL default '0',
  PRIMARY KEY  (`codfactura`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='facturas de ventas a clientes' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `facturasp`
-- 

CREATE TABLE `facturasp` (
  `codfactura` varchar(20) NOT NULL default '',
  `codproveedor` int(5) NOT NULL,
  `fecha` date NOT NULL,
  `iva` tinyint(4) NOT NULL,
  `estado` varchar(1) NOT NULL default '0',
  `totalfactura` float NOT NULL,
  `fechapago` date NOT NULL default '0000-00-00',
  `borrado` varchar(1) NOT NULL default '0',
  PRIMARY KEY  (`codfactura`,`codproveedor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='facturas de compras a proveedores';


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `facturasptmp`
-- 

CREATE TABLE `facturasptmp` (
  `codfactura` int(11) NOT NULL auto_increment,
  `fecha` date NOT NULL,
  PRIMARY KEY  (`codfactura`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='temporal de facturas de proveedores' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `facturastmp`
-- 

CREATE TABLE `facturastmp` (
  `codfactura` int(11) NOT NULL auto_increment,
  `fecha` date NOT NULL,
  PRIMARY KEY  (`codfactura`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='temporal de facturas a clientes' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `familias`
-- 

CREATE TABLE `familias` (
  `codfamilia` int(5) NOT NULL auto_increment,
  `nombre` varchar(20) default NULL,
  `borrado` varchar(1) NOT NULL default '0',
  PRIMARY KEY  (`codfamilia`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='familia de articulos' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `formapago`
-- 

CREATE TABLE `formapago` (
  `codformapago` int(2) NOT NULL auto_increment,
  `nombrefp` varchar(40) NOT NULL,
  `borrado` varchar(1) NOT NULL default '0',
  PRIMARY KEY  (`codformapago`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Forma de pago' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `impuestos`
-- 

CREATE TABLE `impuestos` (
  `codimpuesto` int(3) NOT NULL auto_increment,
  `nombre` varchar(20) default NULL,
  `valor` float NOT NULL,
  `borrado` varchar(1) NOT NULL default '0',
  PRIMARY KEY  (`codimpuesto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='tipos de impuestos' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `librodiario`
-- 

CREATE TABLE `librodiario` (
  `id` int(8) NOT NULL auto_increment,
  `fecha` date NOT NULL default '0000-00-00',
  `tipodocumento` varchar(1) NOT NULL,
  `coddocumento` varchar(20) NOT NULL,
  `codcomercial` int(5) NOT NULL,
  `codformapago` int(2) NOT NULL,
  `numpago` varchar(30) NOT NULL,
  `total` float NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Movimientos diarios' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `pagos`
-- 

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL auto_increment,
  `codfactura` varchar(20) NOT NULL,
  `codproveedor` int(5) NOT NULL,
  `importe` float NOT NULL,
  `codformapago` int(2) NOT NULL,
  `numdocumento` varchar(30) NOT NULL,
  `fechapago` date default '0000-00-00',
  `observaciones` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Pagos de facturas a proveedores' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `proveedores`
-- 

CREATE TABLE `proveedores` (
  `codproveedor` int(5) NOT NULL auto_increment,
  `nombre` varchar(45) NOT NULL,
  `nif` varchar(12) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `codprovincia` int(2) NOT NULL,
  `localidad` varchar(35) NOT NULL,
  `codentidad` int(2) NOT NULL,
  `cuentabancaria` varchar(20) NOT NULL,
  `codpostal` varchar(5) NOT NULL,
  `telefono` varchar(14) NOT NULL,
  `movil` varchar(14) NOT NULL,
  `email` varchar(35) NOT NULL,
  `web` varchar(45) NOT NULL,
  `borrado` varchar(1) NOT NULL default '0',
  PRIMARY KEY  (`codproveedor`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Proveedores' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `provincias`
-- 

CREATE TABLE `provincias` (
  `codprovincia` int(2) NOT NULL auto_increment,
  `nombreprovincia` varchar(40) NOT NULL,
  PRIMARY KEY  (`codprovincia`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Provincias' AUTO_INCREMENT=53 ;

-- 
-- Volcar la base de datos para la tabla `provincias`
-- 

INSERT INTO `provincias` VALUES (1, 'Alava');
INSERT INTO `provincias` VALUES (2, 'Albacete');
INSERT INTO `provincias` VALUES (3, 'Alicante');
INSERT INTO `provincias` VALUES (4, 'Almeria');
INSERT INTO `provincias` VALUES (5, 'Asturias');
INSERT INTO `provincias` VALUES (6, 'Avila');
INSERT INTO `provincias` VALUES (7, 'Badajoz');
INSERT INTO `provincias` VALUES (8, 'Baleares');
INSERT INTO `provincias` VALUES (9, 'Barcelona');
INSERT INTO `provincias` VALUES (10, 'Burgos');
INSERT INTO `provincias` VALUES (11, 'Caceres');
INSERT INTO `provincias` VALUES (12, 'Cadiz');
INSERT INTO `provincias` VALUES (13, 'Cantabria');
INSERT INTO `provincias` VALUES (14, 'Castellon');
INSERT INTO `provincias` VALUES (15, 'Ceuta');
INSERT INTO `provincias` VALUES (16, 'Ciudad Real');
INSERT INTO `provincias` VALUES (17, 'Cordoba');
INSERT INTO `provincias` VALUES (18, 'La Coru�a');
INSERT INTO `provincias` VALUES (19, 'Cuenca');
INSERT INTO `provincias` VALUES (20, 'Gerona');
INSERT INTO `provincias` VALUES (21, 'Granada');
INSERT INTO `provincias` VALUES (22, 'Guadalajara');
INSERT INTO `provincias` VALUES (23, 'Guipuzcoa');
INSERT INTO `provincias` VALUES (24, 'Huelva');
INSERT INTO `provincias` VALUES (25, 'Huesca');
INSERT INTO `provincias` VALUES (26, 'Jaen');
INSERT INTO `provincias` VALUES (27, 'Leon');
INSERT INTO `provincias` VALUES (28, 'Lerida');
INSERT INTO `provincias` VALUES (29, 'Lugo');
INSERT INTO `provincias` VALUES (30, 'Madrid');
INSERT INTO `provincias` VALUES (31, 'Malaga');
INSERT INTO `provincias` VALUES (32, 'Melilla');
INSERT INTO `provincias` VALUES (33, 'Murcia');
INSERT INTO `provincias` VALUES (34, 'Navarra');
INSERT INTO `provincias` VALUES (35, 'Orense');
INSERT INTO `provincias` VALUES (36, 'Palencia');
INSERT INTO `provincias` VALUES (37, 'Las Palmas');
INSERT INTO `provincias` VALUES (38, 'Pontevedra');
INSERT INTO `provincias` VALUES (39, 'La Rioja');
INSERT INTO `provincias` VALUES (40, 'Salamanca');
INSERT INTO `provincias` VALUES (41, 'Sta. Cruz de Tenerife');
INSERT INTO `provincias` VALUES (42, 'Segovia');
INSERT INTO `provincias` VALUES (43, 'Sevilla');
INSERT INTO `provincias` VALUES (44, 'Soria');
INSERT INTO `provincias` VALUES (45, 'Tarragona');
INSERT INTO `provincias` VALUES (46, 'Teruel');
INSERT INTO `provincias` VALUES (47, 'Toledo');
INSERT INTO `provincias` VALUES (48, 'Valencia');
INSERT INTO `provincias` VALUES (49, 'Valladolid');
INSERT INTO `provincias` VALUES (50, 'Vizcaya');
INSERT INTO `provincias` VALUES (51, 'Zamora');
INSERT INTO `provincias` VALUES (52, 'Zaragoza');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tabbackup`
-- 

CREATE TABLE `tabbackup` (
  `id` int(6) NOT NULL auto_increment,
  `denominacion` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `archivo` varchar(40) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `ubicaciones`
-- 

CREATE TABLE `ubicaciones` (
  `codubicacion` int(3) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  `borrado` varchar(1) NOT NULL default '0',
  PRIMARY KEY  (`codubicacion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Ubicaciones' AUTO_INCREMENT=1 ;



