--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

--
-- Name: addauth(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addauth(text) RETURNS boolean
    LANGUAGE plpgsql
    AS $_$ 
DECLARE
	lockid alias for $1;
	okay boolean;
	myrec record;
BEGIN
	-- check to see if table exists
	--  if not, CREATE TEMP TABLE mylock (transid xid, lockcode text)
	okay := 'f';
	FOR myrec IN SELECT * FROM pg_class WHERE relname = 'temp_lock_have_table' LOOP
		okay := 't';
	END LOOP; 
	IF (okay <> 't') THEN 
		CREATE TEMP TABLE temp_lock_have_table (transid xid, lockcode text);
			-- this will only work from pgsql7.4 up
			-- ON COMMIT DELETE ROWS;
	END IF;

	--  INSERT INTO mylock VALUES ( $1)
--	EXECUTE 'INSERT INTO temp_lock_have_table VALUES ( '||
--		quote_literal(getTransactionID()) || ',' ||
--		quote_literal(lockid) ||')';

	INSERT INTO temp_lock_have_table VALUES (getTransactionID(), lockid);

	RETURN true::boolean;
END;
$_$;


ALTER FUNCTION public.addauth(text) OWNER TO postgres;

--
-- Name: addgeometrycolumn(character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, integer, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$ 
DECLARE
	ret  text;
BEGIN
	SELECT AddGeometryColumn('','',$1,$2,$3,$4,$5) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, integer, character varying, integer) OWNER TO postgres;

--
-- Name: addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) RETURNS text
    LANGUAGE plpgsql STABLE STRICT
    AS $_$ 
DECLARE
	ret  text;
BEGIN
	SELECT AddGeometryColumn('',$1,$2,$3,$4,$5,$6) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) OWNER TO postgres;

--
-- Name: addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1;
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	new_srid alias for $5;
	new_type alias for $6;
	new_dim alias for $7;
	rec RECORD;
	sr varchar;
	real_schema name;
	sql text;

BEGIN

	-- Verify geometry type
	IF ( NOT ( (new_type = 'GEOMETRY') OR
			   (new_type = 'GEOMETRYCOLLECTION') OR
			   (new_type = 'POINT') OR
			   (new_type = 'MULTIPOINT') OR
			   (new_type = 'POLYGON') OR
			   (new_type = 'MULTIPOLYGON') OR
			   (new_type = 'LINESTRING') OR
			   (new_type = 'MULTILINESTRING') OR
			   (new_type = 'GEOMETRYCOLLECTIONM') OR
			   (new_type = 'POINTM') OR
			   (new_type = 'MULTIPOINTM') OR
			   (new_type = 'POLYGONM') OR
			   (new_type = 'MULTIPOLYGONM') OR
			   (new_type = 'LINESTRINGM') OR
			   (new_type = 'MULTILINESTRINGM') OR
			   (new_type = 'CIRCULARSTRING') OR
			   (new_type = 'CIRCULARSTRINGM') OR
			   (new_type = 'COMPOUNDCURVE') OR
			   (new_type = 'COMPOUNDCURVEM') OR
			   (new_type = 'CURVEPOLYGON') OR
			   (new_type = 'CURVEPOLYGONM') OR
			   (new_type = 'MULTICURVE') OR
			   (new_type = 'MULTICURVEM') OR
			   (new_type = 'MULTISURFACE') OR
			   (new_type = 'MULTISURFACEM')) )
	THEN
		RAISE EXCEPTION 'Invalid type name - valid ones are:
	POINT, MULTIPOINT,
	LINESTRING, MULTILINESTRING,
	POLYGON, MULTIPOLYGON,
	CIRCULARSTRING, COMPOUNDCURVE, MULTICURVE,
	CURVEPOLYGON, MULTISURFACE,
	GEOMETRY, GEOMETRYCOLLECTION,
	POINTM, MULTIPOINTM,
	LINESTRINGM, MULTILINESTRINGM,
	POLYGONM, MULTIPOLYGONM,
	CIRCULARSTRINGM, COMPOUNDCURVEM, MULTICURVEM
	CURVEPOLYGONM, MULTISURFACEM,
	or GEOMETRYCOLLECTIONM';
		RETURN 'fail';
	END IF;


	-- Verify dimension
	IF ( (new_dim >4) OR (new_dim <0) ) THEN
		RAISE EXCEPTION 'invalid dimension';
		RETURN 'fail';
	END IF;

	IF ( (new_type LIKE '%M') AND (new_dim!=3) ) THEN
		RAISE EXCEPTION 'TypeM needs 3 dimensions';
		RETURN 'fail';
	END IF;


	-- Verify SRID
	IF ( new_srid != -1 ) THEN
		SELECT SRID INTO sr FROM spatial_ref_sys WHERE SRID = new_srid;
		IF NOT FOUND THEN
			RAISE EXCEPTION 'AddGeometryColumns() - invalid SRID';
			RETURN 'fail';
		END IF;
	END IF;


	-- Verify schema
	IF ( schema_name IS NOT NULL AND schema_name != '' ) THEN
		sql := 'SELECT nspname FROM pg_namespace ' ||
			'WHERE text(nspname) = ' || quote_literal(schema_name) ||
			'LIMIT 1';
		RAISE DEBUG '%', sql;
		EXECUTE sql INTO real_schema;

		IF ( real_schema IS NULL ) THEN
			RAISE EXCEPTION 'Schema % is not a valid schemaname', quote_literal(schema_name);
			RETURN 'fail';
		END IF;
	END IF;

	IF ( real_schema IS NULL ) THEN
		RAISE DEBUG 'Detecting schema';
		sql := 'SELECT n.nspname AS schemaname ' ||
			'FROM pg_catalog.pg_class c ' ||
			  'JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace ' ||
			'WHERE c.relkind = ' || quote_literal('r') ||
			' AND n.nspname NOT IN (' || quote_literal('pg_catalog') || ', ' || quote_literal('pg_toast') || ')' ||
			' AND pg_catalog.pg_table_is_visible(c.oid)' ||
			' AND c.relname = ' || quote_literal(table_name);
		RAISE DEBUG '%', sql;
		EXECUTE sql INTO real_schema;

		IF ( real_schema IS NULL ) THEN
			RAISE EXCEPTION 'Table % does not occur in the search_path', quote_literal(table_name);
			RETURN 'fail';
		END IF;
	END IF;
	

	-- Add geometry column to table
	sql := 'ALTER TABLE ' ||
		quote_ident(real_schema) || '.' || quote_ident(table_name)
		|| ' ADD COLUMN ' || quote_ident(column_name) ||
		' geometry ';
	RAISE DEBUG '%', sql;
	EXECUTE sql;


	-- Delete stale record in geometry_columns (if any)
	sql := 'DELETE FROM geometry_columns WHERE
		f_table_catalog = ' || quote_literal('') ||
		' AND f_table_schema = ' ||
		quote_literal(real_schema) ||
		' AND f_table_name = ' || quote_literal(table_name) ||
		' AND f_geometry_column = ' || quote_literal(column_name);
	RAISE DEBUG '%', sql;
	EXECUTE sql;


	-- Add record in geometry_columns
	sql := 'INSERT INTO geometry_columns (f_table_catalog,f_table_schema,f_table_name,' ||
										  'f_geometry_column,coord_dimension,srid,type)' ||
		' VALUES (' ||
		quote_literal('') || ',' ||
		quote_literal(real_schema) || ',' ||
		quote_literal(table_name) || ',' ||
		quote_literal(column_name) || ',' ||
		new_dim::text || ',' ||
		new_srid::text || ',' ||
		quote_literal(new_type) || ')';
	RAISE DEBUG '%', sql;
	EXECUTE sql;


	-- Add table CHECKs
	sql := 'ALTER TABLE ' ||
		quote_ident(real_schema) || '.' || quote_ident(table_name)
		|| ' ADD CONSTRAINT '
		|| quote_ident('enforce_srid_' || column_name)
		|| ' CHECK (ST_SRID(' || quote_ident(column_name) ||
		') = ' || new_srid::text || ')' ;
	RAISE DEBUG '%', sql;
	EXECUTE sql;

	sql := 'ALTER TABLE ' ||
		quote_ident(real_schema) || '.' || quote_ident(table_name)
		|| ' ADD CONSTRAINT '
		|| quote_ident('enforce_dims_' || column_name)
		|| ' CHECK (ST_NDims(' || quote_ident(column_name) ||
		') = ' || new_dim::text || ')' ;
	RAISE DEBUG '%', sql;
	EXECUTE sql;

	IF ( NOT (new_type = 'GEOMETRY')) THEN
		sql := 'ALTER TABLE ' ||
			quote_ident(real_schema) || '.' || quote_ident(table_name) || ' ADD CONSTRAINT ' ||
			quote_ident('enforce_geotype_' || column_name) ||
			' CHECK (GeometryType(' ||
			quote_ident(column_name) || ')=' ||
			quote_literal(new_type) || ' OR (' ||
			quote_ident(column_name) || ') is null)';
		RAISE DEBUG '%', sql;
		EXECUTE sql;
	END IF;

	RETURN
		real_schema || '.' ||
		table_name || '.' || column_name ||
		' SRID:' || new_srid::text ||
		' TYPE:' || new_type ||
		' DIMS:' || new_dim::text || ' ';
END;
$_$;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) OWNER TO postgres;

--
-- Name: checkauth(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION checkauth(text, text) RETURNS integer
    LANGUAGE sql
    AS $_$ SELECT CheckAuth('', $1, $2) $_$;


ALTER FUNCTION public.checkauth(text, text) OWNER TO postgres;

--
-- Name: checkauth(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION checkauth(text, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$ 
DECLARE
	schema text;
BEGIN
	IF NOT LongTransactionsEnabled() THEN
		RAISE EXCEPTION 'Long transaction support disabled, use EnableLongTransaction() to enable.';
	END IF;

	if ( $1 != '' ) THEN
		schema = $1;
	ELSE
		SELECT current_schema() into schema;
	END IF;

	-- TODO: check for an already existing trigger ?

	EXECUTE 'CREATE TRIGGER check_auth BEFORE UPDATE OR DELETE ON ' 
		|| quote_ident(schema) || '.' || quote_ident($2)
		||' FOR EACH ROW EXECUTE PROCEDURE CheckAuthTrigger('
		|| quote_literal($3) || ')';

	RETURN 0;
END;
$_$;


ALTER FUNCTION public.checkauth(text, text, text) OWNER TO postgres;

--
-- Name: difference(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION difference(text, text) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/fuzzystrmatch', 'difference';


ALTER FUNCTION public.difference(text, text) OWNER TO postgres;

--
-- Name: disablelongtransactions(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION disablelongtransactions() RETURNS text
    LANGUAGE plpgsql
    AS $$ 
DECLARE
	rec RECORD;

BEGIN

	--
	-- Drop all triggers applied by CheckAuth()
	--
	FOR rec IN
		SELECT c.relname, t.tgname, t.tgargs FROM pg_trigger t, pg_class c, pg_proc p
		WHERE p.proname = 'checkauthtrigger' and t.tgfoid = p.oid and t.tgrelid = c.oid
	LOOP
		EXECUTE 'DROP TRIGGER ' || quote_ident(rec.tgname) ||
			' ON ' || quote_ident(rec.relname);
	END LOOP;

	--
	-- Drop the authorization_table table
	--
	FOR rec IN SELECT * FROM pg_class WHERE relname = 'authorization_table' LOOP
		DROP TABLE authorization_table;
	END LOOP;

	--
	-- Drop the authorized_tables view
	--
	FOR rec IN SELECT * FROM pg_class WHERE relname = 'authorized_tables' LOOP
		DROP VIEW authorized_tables;
	END LOOP;

	RETURN 'Long transactions support disabled';
END;
$$;


ALTER FUNCTION public.disablelongtransactions() OWNER TO postgres;

--
-- Name: dmetaphone(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dmetaphone(text) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/fuzzystrmatch', 'dmetaphone';


ALTER FUNCTION public.dmetaphone(text) OWNER TO postgres;

--
-- Name: dmetaphone_alt(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dmetaphone_alt(text) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/fuzzystrmatch', 'dmetaphone_alt';


ALTER FUNCTION public.dmetaphone_alt(text) OWNER TO postgres;

--
-- Name: dropgeometrycolumn(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrycolumn(character varying, character varying) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	ret text;
BEGIN
	SELECT DropGeometryColumn('','',$1,$2) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.dropgeometrycolumn(character varying, character varying) OWNER TO postgres;

--
-- Name: dropgeometrycolumn(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrycolumn(character varying, character varying, character varying) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	ret text;
BEGIN
	SELECT DropGeometryColumn('',$1,$2,$3) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.dropgeometrycolumn(character varying, character varying, character varying) OWNER TO postgres;

--
-- Name: dropgeometrycolumn(character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrycolumn(character varying, character varying, character varying, character varying) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1; 
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	myrec RECORD;
	okay boolean;
	real_schema name;

BEGIN


	-- Find, check or fix schema_name
	IF ( schema_name != '' ) THEN
		okay = 'f';

		FOR myrec IN SELECT nspname FROM pg_namespace WHERE text(nspname) = schema_name LOOP
			okay := 't';
		END LOOP;

		IF ( okay <> 't' ) THEN
			RAISE NOTICE 'Invalid schema name - using current_schema()';
			SELECT current_schema() into real_schema;
		ELSE
			real_schema = schema_name;
		END IF;
	ELSE
		SELECT current_schema() into real_schema;
	END IF;

 	-- Find out if the column is in the geometry_columns table
	okay = 'f';
	FOR myrec IN SELECT * from geometry_columns where f_table_schema = text(real_schema) and f_table_name = table_name and f_geometry_column = column_name LOOP
		okay := 't';
	END LOOP; 
	IF (okay <> 't') THEN 
		RAISE EXCEPTION 'column not found in geometry_columns table';
		RETURN 'f';
	END IF;

	-- Remove ref from geometry_columns table
	EXECUTE 'delete from geometry_columns where f_table_schema = ' ||
		quote_literal(real_schema) || ' and f_table_name = ' ||
		quote_literal(table_name)  || ' and f_geometry_column = ' ||
		quote_literal(column_name);
	
	-- Remove table column
	EXECUTE 'ALTER TABLE ' || quote_ident(real_schema) || '.' ||
		quote_ident(table_name) || ' DROP COLUMN ' ||
		quote_ident(column_name);

	RETURN real_schema || '.' || table_name || '.' || column_name ||' effectively removed.';
	
END;
$_$;


ALTER FUNCTION public.dropgeometrycolumn(character varying, character varying, character varying, character varying) OWNER TO postgres;

--
-- Name: dropgeometrytable(character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrytable(character varying) RETURNS text
    LANGUAGE sql STRICT
    AS $_$ SELECT DropGeometryTable('','',$1) $_$;


ALTER FUNCTION public.dropgeometrytable(character varying) OWNER TO postgres;

--
-- Name: dropgeometrytable(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrytable(character varying, character varying) RETURNS text
    LANGUAGE sql STRICT
    AS $_$ SELECT DropGeometryTable('',$1,$2) $_$;


ALTER FUNCTION public.dropgeometrytable(character varying, character varying) OWNER TO postgres;

--
-- Name: dropgeometrytable(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrytable(character varying, character varying, character varying) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1; 
	schema_name alias for $2;
	table_name alias for $3;
	real_schema name;

BEGIN

	IF ( schema_name = '' ) THEN
		SELECT current_schema() into real_schema;
	ELSE
		real_schema = schema_name;
	END IF;

	-- Remove refs from geometry_columns table
	EXECUTE 'DELETE FROM geometry_columns WHERE ' ||
		'f_table_schema = ' || quote_literal(real_schema) ||
		' AND ' ||
		' f_table_name = ' || quote_literal(table_name);
	
	-- Remove table 
	EXECUTE 'DROP TABLE '
		|| quote_ident(real_schema) || '.' ||
		quote_ident(table_name);

	RETURN
		real_schema || '.' ||
		table_name ||' dropped.';
	
END;
$_$;


ALTER FUNCTION public.dropgeometrytable(character varying, character varying, character varying) OWNER TO postgres;

--
-- Name: dup(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dup(integer, OUT f1 integer, OUT f2 text) RETURNS record
    LANGUAGE sql
    AS $_$ SELECT $1, CAST($1 AS text) || ' is text' $_$;


ALTER FUNCTION public.dup(integer, OUT f1 integer, OUT f2 text) OWNER TO postgres;

--
-- Name: enablelongtransactions(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION enablelongtransactions() RETURNS text
    LANGUAGE plpgsql
    AS $$ 
DECLARE
	"query" text;
	exists bool;
	rec RECORD;

BEGIN

	exists = 'f';
	FOR rec IN SELECT * FROM pg_class WHERE relname = 'authorization_table'
	LOOP
		exists = 't';
	END LOOP;

	IF NOT exists
	THEN
		"query" = 'CREATE TABLE authorization_table (
			toid oid, -- table oid
			rid text, -- row id
			expires timestamp,
			authid text
		)';
		EXECUTE "query";
	END IF;

	exists = 'f';
	FOR rec IN SELECT * FROM pg_class WHERE relname = 'authorized_tables'
	LOOP
		exists = 't';
	END LOOP;

	IF NOT exists THEN
		"query" = 'CREATE VIEW authorized_tables AS ' ||
			'SELECT ' ||
			'n.nspname as schema, ' ||
			'c.relname as table, trim(' ||
			quote_literal(chr(92) || '000') ||
			' from t.tgargs) as id_column ' ||
			'FROM pg_trigger t, pg_class c, pg_proc p ' ||
			', pg_namespace n ' ||
			'WHERE p.proname = ' || quote_literal('checkauthtrigger') ||
			' AND c.relnamespace = n.oid' ||
			' AND t.tgfoid = p.oid and t.tgrelid = c.oid';
		EXECUTE "query";
	END IF;

	RETURN 'Long transactions support enabled';
END;
$$;


ALTER FUNCTION public.enablelongtransactions() OWNER TO postgres;

--
-- Name: find_srid(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION find_srid(character varying, character varying, character varying) RETURNS integer
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
DECLARE
	schem text;
	tabl text;
	sr int4;
BEGIN
	IF $1 IS NULL THEN
	  RAISE EXCEPTION 'find_srid() - schema is NULL!';
	END IF;
	IF $2 IS NULL THEN
	  RAISE EXCEPTION 'find_srid() - table name is NULL!';
	END IF;
	IF $3 IS NULL THEN
	  RAISE EXCEPTION 'find_srid() - column name is NULL!';
	END IF;
	schem = $1;
	tabl = $2;
-- if the table contains a . and the schema is empty
-- split the table into a schema and a table
-- otherwise drop through to default behavior
	IF ( schem = '' and tabl LIKE '%.%' ) THEN
	 schem = substr(tabl,1,strpos(tabl,'.')-1);
	 tabl = substr(tabl,length(schem)+2);
	ELSE
	 schem = schem || '%';
	END IF;

	select SRID into sr from geometry_columns where f_table_schema like schem and f_table_name = tabl and f_geometry_column = $3;
	IF NOT FOUND THEN
	   RAISE EXCEPTION 'find_srid() - couldnt find the corresponding SRID - is the geometry registered in the GEOMETRY_COLUMNS table?  Is there an uppercase/lowercase missmatch?';
	END IF;
	return sr;
END;
$_$;


ALTER FUNCTION public.find_srid(character varying, character varying, character varying) OWNER TO postgres;

--
-- Name: fix_geometry_columns(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION fix_geometry_columns() RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
	mislinked record;
	result text;
	linked integer;
	deleted integer;
	foundschema integer;
BEGIN

	-- Since 7.3 schema support has been added.
	-- Previous postgis versions used to put the database name in
	-- the schema column. This needs to be fixed, so we try to 
	-- set the correct schema for each geometry_colums record
	-- looking at table, column, type and srid.
	UPDATE geometry_columns SET f_table_schema = n.nspname
		FROM pg_namespace n, pg_class c, pg_attribute a,
			pg_constraint sridcheck, pg_constraint typecheck
	        WHERE ( f_table_schema is NULL
		OR f_table_schema = ''
	        OR f_table_schema NOT IN (
	                SELECT nspname::varchar
	                FROM pg_namespace nn, pg_class cc, pg_attribute aa
	                WHERE cc.relnamespace = nn.oid
	                AND cc.relname = f_table_name::name
	                AND aa.attrelid = cc.oid
	                AND aa.attname = f_geometry_column::name))
	        AND f_table_name::name = c.relname
	        AND c.oid = a.attrelid
	        AND c.relnamespace = n.oid
	        AND f_geometry_column::name = a.attname

	        AND sridcheck.conrelid = c.oid
		AND sridcheck.consrc LIKE '(srid(% = %)'
	        AND sridcheck.consrc ~ textcat(' = ', srid::text)

	        AND typecheck.conrelid = c.oid
		AND typecheck.consrc LIKE
		'((geometrytype(%) = ''%''::text) OR (% IS NULL))'
	        AND typecheck.consrc ~ textcat(' = ''', type::text)

	        AND NOT EXISTS (
	                SELECT oid FROM geometry_columns gc
	                WHERE c.relname::varchar = gc.f_table_name
	                AND n.nspname::varchar = gc.f_table_schema
	                AND a.attname::varchar = gc.f_geometry_column
	        );

	GET DIAGNOSTICS foundschema = ROW_COUNT;

	-- no linkage to system table needed
	return 'fixed:'||foundschema::text;

END;
$$;


ALTER FUNCTION public.fix_geometry_columns() OWNER TO postgres;

--
-- Name: func_escopo(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION func_escopo() RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
   quantidade INTEGER := 30;
BEGIN
   RAISE NOTICE 'Aqui a quantidade é %', quantidade;  -- A quantidade aqui é 30
   quantidade := 50;
   --
   -- Criar um sub-bloco
   --
   DECLARE
       quantidade INTEGER := 80;
   BEGIN
       RAISE NOTICE 'Aqui a quantidade é %', quantidade;  -- A quantidade aqui é 80
   END;
   RAISE NOTICE 'Aqui a quantidade é %', quantidade;  -- A quantidade aqui é 50
   RETURN quantidade;
END;
 
$$;


ALTER FUNCTION public.func_escopo() OWNER TO postgres;

--
-- Name: func_escopo2(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION func_escopo2() RETURNS integer
    LANGUAGE plpgsql
    AS $$

DECLARE

    quantidade integer := 30;

BEGIN

    RAISE NOTICE 'Aqui a quantidade é %', quantidade;  -- A quantidade aqui é 30

    quantidade := 50;

    --

    -- Criar um sub-bloco

    --

    DECLARE

        quantidade integer := 80;

    BEGIN

        RAISE NOTICE 'Aqui a quantidade é %', quantidade;  -- A quantidade aqui é 80

    END;



    RAISE NOTICE 'Aqui a quantidade é %', quantidade;  -- A quantidade aqui é 50



    RETURN quantidade;

END;

$$;


ALTER FUNCTION public.func_escopo2() OWNER TO postgres;

--
-- Name: get_proj4_from_srid(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_proj4_from_srid(integer) RETURNS text
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
BEGIN
	RETURN proj4text::text FROM spatial_ref_sys WHERE srid= $1;
END;
$_$;


ALTER FUNCTION public.get_proj4_from_srid(integer) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: kingdom; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE kingdom (
    idkingdom integer NOT NULL,
    kingdom text NOT NULL,
    colvalidation boolean DEFAULT false
);


ALTER TABLE public.kingdom OWNER TO postgres;

--
-- Name: getallan(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getallan() RETURNS SETOF kingdom
    LANGUAGE plpgsql
    AS $$

DECLARE
   l_row kingdom;
   l_array text[];

BEGIN
   
   -- Loop throught rows
   FOR l_row IN
      SELECT * FROM kingdom
   LOOP
      -- Put all data into array
      SELECT array_append(l_array,l_row.kingdom) INTO l_array;
      
   END LOOP;
  
   
END;
$$;


ALTER FUNCTION public.getallan() OWNER TO postgres;

--
-- Name: getallan1(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getallan1() RETURNS SETOF text[]
    LANGUAGE plpgsql
    AS $$

DECLARE
   l_row kingdom;
   l_array text[];

BEGIN
   
select array_append(l_array,kingdom) from kingdom;
   
END;
$$;


ALTER FUNCTION public.getallan1() OWNER TO postgres;

--
-- Name: recordleveldynamicproperty; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE recordleveldynamicproperty (
    idrecordlevelelement integer NOT NULL,
    iddynamicproperty integer NOT NULL
);


ALTER TABLE public.recordleveldynamicproperty OWNER TO postgres;

--
-- Name: getnndynamicpropertyr(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getnndynamicpropertyr(i integer) RETURNS recordleveldynamicproperty
    LANGUAGE sql
    AS $_$select * from recordleveldynamicproperty where idrecordlevelelement=$1;$_$;


ALTER FUNCTION public.getnndynamicpropertyr(i integer) OWNER TO postgres;

--
-- Name: getnndynamicpropertyr2(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getnndynamicpropertyr2(i integer) RETURNS SETOF recordleveldynamicproperty
    LANGUAGE sql
    AS $_$select * from recordleveldynamicproperty where idrecordlevelelement=$1;$_$;


ALTER FUNCTION public.getnndynamicpropertyr2(i integer) OWNER TO postgres;

--
-- Name: dynamicproperty; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE dynamicproperty (
    iddynamicproperty integer NOT NULL,
    dynamicproperty text NOT NULL
);


ALTER TABLE public.dynamicproperty OWNER TO postgres;

--
-- Name: getnndynamicpropertyr3(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getnndynamicpropertyr3(i integer) RETURNS SETOF dynamicproperty
    LANGUAGE sql
    AS $_$select d.iddynamicproperty, dynamicproperty from recordleveldynamicproperty r left join dynamicproperty d on d.iddynamicproperty = r.iddynamicproperty where r.idrecordlevelelement=$1;$_$;


ALTER FUNCTION public.getnndynamicpropertyr3(i integer) OWNER TO postgres;

--
-- Name: getnndynamicpropertyr4(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getnndynamicpropertyr4(i integer) RETURNS SETOF text
    LANGUAGE sql
    AS $_$select dynamicproperty from recordleveldynamicproperty r left join dynamicproperty d on d.iddynamicproperty = r.iddynamicproperty where r.idrecordlevelelement=$1;$_$;


ALTER FUNCTION public.getnndynamicpropertyr4(i integer) OWNER TO postgres;

--
-- Name: getnndynamicpropertyr5(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getnndynamicpropertyr5(i integer) RETURNS text[]
    LANGUAGE sql
    AS $_$select string_to_array(dynamicproperty,'') from recordleveldynamicproperty r left join dynamicproperty d on d.iddynamicproperty = r.iddynamicproperty where r.idrecordlevelelement=$1;$_$;


ALTER FUNCTION public.getnndynamicpropertyr5(i integer) OWNER TO postgres;

--
-- Name: increment(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION increment(i integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
        BEGIN
                RETURN i + 1;
        END;
$$;


ALTER FUNCTION public.increment(i integer) OWNER TO postgres;

--
-- Name: interactionsave(text, text, integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION interactionsave(text, text, integer, text) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    aux1 integer;
    aux2 integer;
    aux0 integer;
    sp1 integer;
    sp2 integer;
    interact integer;
    status text;
BEGIN

    FOR aux1 IN select idspecimen from specimen sp left join recordlevelelement r on r.idrecordlevelelement = sp.idrecordlevelelement where r.globaluniqueidentifier=$1
    LOOP
        sp1 := aux1;
    END LOOP;
    
    FOR aux2 IN select idspecimen from specimen sp left join recordlevelelement r on r.idrecordlevelelement = sp.idrecordlevelelement where r.globaluniqueidentifier=$2
    LOOP
        sp2 := aux2;
    END LOOP;
    
    FOR aux0 IN select idinteraction from interaction as i left join specimen sp_2 on sp_2.idspecimen = i.idspecimen2 left join specimen sp_1 on sp_1.idspecimen = i.idspecimen1  where sp_1.idspecimen=sp1 AND sp_2.idspecimen=sp2 AND i.idinteractiontype=$3
    LOOP
        interact := aux0;
    END LOOP;
    
    IF interact > 0 THEN
    EXECUTE 'UPDATE interaction SET interactionrelatedinformation=''' || $4 || ''' WHERE idinteraction='||interact;
    status := 'update';
    ELSE
    EXECUTE 'INSERT INTO interaction VALUES (DEFAULT,'||sp1||', '||sp2||', '||$3||', \''||$4||'\', DEFAULT,DEFAULT)';
    status := 'insert';
    END IF;
	
    
    
    RETURN status;
END
$_$;


ALTER FUNCTION public.interactionsave(text, text, integer, text) OWNER TO postgres;

--
-- Name: interactionsave2(text, text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION interactionsave2(text, text, text, text) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    aux1 integer;
    aux2 integer;
    aux3 integer;
    aux0 integer;
    sp1 integer;
    sp2 integer;
    id_inte_type integer;
    interact integer;
    status text;
BEGIN

    FOR aux1 IN select idspecimen from specimen sp left join recordlevelelement r on r.idrecordlevelelement = sp.idrecordlevelelement where r.globaluniqueidentifier=$1
    LOOP
        sp1 := aux1;
    END LOOP;
    
    FOR aux2 IN select idspecimen from specimen sp left join recordlevelelement r on r.idrecordlevelelement = sp.idrecordlevelelement where r.globaluniqueidentifier=$2
    LOOP
        sp2 := aux2;
    END LOOP;

    FOR aux3 IN select idinteractiontype FROM interactiontype where interactiontype=$3
    LOOP
	id_inte_type := aux3;
    END LOOP;
    
    FOR aux0 IN select idinteraction from interaction as i left join specimen sp_2 on sp_2.idspecimen = i.idspecimen2 
    left join specimen sp_1 on sp_1.idspecimen = i.idspecimen1  where sp_1.idspecimen=sp1 AND sp_2.idspecimen=sp2 AND i.idinteractiontype=id_inte_type
    LOOP
        interact := aux0;
    END LOOP;

    IF sp1 > 0 AND sp2 > 0 AND id_inte_type > 0 THEN
	IF interact > 0 THEN
		EXECUTE 'UPDATE interaction SET interactionrelatedinformation=''' || $4 || ''' WHERE idinteraction='||interact;
		status := 'update';
	ELSE
		EXECUTE 'INSERT INTO interaction VALUES (DEFAULT,' || sp1 || ', ' || sp2 || ', ' || id_inte_type || ', E''' || $4 || ''', DEFAULT, DEFAULT)';
		status := 'insert';
	END IF;
    ELSE 
	status := 'error';
    END IF;

    IF status = 'update' THEN
	EXECUTE 'INSERT INTO log VALUES (DEFAULT, DEFAULT, DEFAULT, DEFAULT, E''update'', E''interaction'', E''spreadsheetsync'', ' || interact || ', DEFAULT)';
    END IF;

    IF status = 'insert' THEN
	FOR aux0 IN select idinteraction from interaction as i left join specimen sp_2 on sp_2.idspecimen = i.idspecimen2 
	left join specimen sp_1 on sp_1.idspecimen = i.idspecimen1  where sp_1.idspecimen=sp1 AND sp_2.idspecimen=sp2 AND i.idinteractiontype=id_inte_type
	LOOP
		interact := aux0;
	END LOOP;
	EXECUTE 'INSERT INTO log VALUES (DEFAULT, DEFAULT, DEFAULT, DEFAULT, E''create'', E''interaction'', E''spreadsheetsync'', ' || interact || ', DEFAULT)';
    END IF;
    
    RETURN status;
END
$_$;


ALTER FUNCTION public.interactionsave2(text, text, text, text) OWNER TO postgres;

--
-- Name: interactionsave3(text, text, text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION interactionsave3(text, text, text, text, text) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    aux1 integer;
    aux2 integer;
    aux3 integer;
    aux0 integer;
    sp1 integer;
    sp2 integer;
    id_inte_type integer;
    interact integer;
    status text;
BEGIN

    FOR aux1 IN select idspecimen from specimen sp left join recordlevelelement r on r.idrecordlevelelement = sp.idrecordlevelelement where r.globaluniqueidentifier=$1
    LOOP
        sp1 := aux1;
    END LOOP;
    
    FOR aux2 IN select idspecimen from specimen sp left join recordlevelelement r on r.idrecordlevelelement = sp.idrecordlevelelement where r.globaluniqueidentifier=$2
    LOOP
        sp2 := aux2;
    END LOOP;

    FOR aux3 IN select idinteractiontype FROM interactiontype where interactiontype=$3
    LOOP
	id_inte_type := aux3;
    END LOOP;
    
    FOR aux0 IN select idinteraction from interaction as i left join specimen sp_2 on sp_2.idspecimen = i.idspecimen2 
    left join specimen sp_1 on sp_1.idspecimen = i.idspecimen1  where sp_1.idspecimen=sp1 AND sp_2.idspecimen=sp2 AND i.idinteractiontype=id_inte_type
    LOOP
        interact := aux0;
    END LOOP;

    IF sp1 > 0 AND sp2 > 0 AND id_inte_type > 0 THEN
	IF interact > 0 THEN
		EXECUTE 'UPDATE interaction SET interactionrelatedinformation=''' || $4 || ''' WHERE idinteraction='||interact;
		status := 'update';
	ELSE
		EXECUTE 'INSERT INTO interaction VALUES (DEFAULT,' || sp1 || ', ' || sp2 || ', ' || id_inte_type || ', E''' || $4 || ''', DEFAULT, DEFAULT,'||$5||')';
		status := 'insert';
	END IF;
    ELSE 
	status := 'error';
    END IF;

    IF status = 'update' THEN
	EXECUTE 'INSERT INTO log VALUES (DEFAULT, DEFAULT, DEFAULT, DEFAULT, E''update'', E''interaction'', E''spreadsheetsync'', ' || interact || ', DEFAULT,'||$5||')';
    END IF;

    IF status = 'insert' THEN
	FOR aux0 IN select idinteraction from interaction as i left join specimen sp_2 on sp_2.idspecimen = i.idspecimen2 
	left join specimen sp_1 on sp_1.idspecimen = i.idspecimen1  where sp_1.idspecimen=sp1 AND sp_2.idspecimen=sp2 AND i.idinteractiontype=id_inte_type
	LOOP
		interact := aux0;
	END LOOP;
	EXECUTE 'INSERT INTO log VALUES (DEFAULT, DEFAULT, DEFAULT, DEFAULT, E''create'', E''interaction'', E''spreadsheetsync'', ' || interact || ', DEFAULT,'||$5||')';
    END IF;
    
    RETURN status;
END
$_$;


ALTER FUNCTION public.interactionsave3(text, text, text, text, text) OWNER TO postgres;

--
-- Name: interactionsave_test(text, text, integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION interactionsave_test(text, text, integer, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    aux1 integer;
    aux2 integer;
    aux0 integer;
    sp1 integer;
    sp2 integer;
    interact integer;
BEGIN

    FOR aux1 IN select idspecimen from specimen sp left join recordlevelelement r on r.idrecordlevelelement = sp.idrecordlevelelement where r.globaluniqueidentifier=$1
    LOOP
        sp1 := aux1;
    END LOOP;
    
    FOR aux2 IN select idspecimen from specimen sp left join recordlevelelement r on r.idrecordlevelelement = sp.idrecordlevelelement where r.globaluniqueidentifier=$2
    LOOP
        sp2 := aux2;
    END LOOP;
    
    FOR aux0 IN select idinteraction from interaction as i left join specimen sp_2 on sp_2.idspecimen = i.idspecimen2 left join specimen sp_1 on sp_1.idspecimen = i.idspecimen1  where sp_1.idspecimen=sp1 AND sp_2.idspecimen=sp2 AND i.idinteractiontype=$3
    LOOP
        interact := aux0;
    END LOOP;
    
    IF interact > 0 THEN
    EXECUTE 'UPDATE interaction SET interactionrelatedinformation=''' || $4 || ''' WHERE idinteraction='||interact;
    ELSE
    EXECUTE 'INSERT INTO interaction VALUES (DEFAULT,'||sp1||', '||sp2||', '||$3||', \''||$4||'\', DEFAULT,DEFAULT)';
    END IF;
	
    
    
    RETURN interact;
END
$_$;


ALTER FUNCTION public.interactionsave_test(text, text, integer, text) OWNER TO postgres;

--
-- Name: specimen; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE specimen (
    idspecimen integer NOT NULL,
    idrecordlevelelement integer,
    idoccurrenceelement integer,
    idcuratorialelement integer,
    ideventelement integer,
    ididentificationelement integer,
    idtaxonomicelement integer,
    idgeospatialelement integer,
    idlocalityelement integer,
    idmonitoring integer,
    idgroup integer,
    aux integer
);


ALTER TABLE public.specimen OWNER TO postgres;

--
-- Name: j_get100specimen(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION j_get100specimen() RETURNS SETOF specimen
    LANGUAGE sql
    AS $$select * from specimen limit 100;$$;


ALTER FUNCTION public.j_get100specimen() OWNER TO postgres;

--
-- Name: j_get100specimen(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION j_get100specimen(i integer) RETURNS SETOF specimen
    LANGUAGE sql
    AS $_$select * from specimen where idspecimen=$1;$_$;


ALTER FUNCTION public.j_get100specimen(i integer) OWNER TO postgres;

--
-- Name: johnny_sum(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION johnny_sum(a integer, b integer) RETURNS integer
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $$
BEGIN
  /*
   *  My first trivial PL/pgSQL function.
   */
  RETURN a + b;
END;
$$;


ALTER FUNCTION public.johnny_sum(a integer, b integer) OWNER TO postgres;

--
-- Name: jteste1(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION jteste1() RETURNS SETOF specimen
    LANGUAGE plpgsql
    AS $$
DECLARE
    r specimen%rowtype;
BEGIN
    FOR r IN SELECT idspecimen FROM specimen limit 100

    LOOP
        -- can do some processing here
        RETURN NEXT r; -- return next row of SELECT
    END LOOP;
    RETURN;
END
$$;


ALTER FUNCTION public.jteste1() OWNER TO postgres;

--
-- Name: jteste2(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION jteste2() RETURNS SETOF text
    LANGUAGE plpgsql
    AS $$
DECLARE
    r specimen%rowtype;
    t text;
BEGIN
    FOR r IN SELECT idspecimen FROM specimen limit 100

    LOOP
        t := t || r;
        RETURN NEXT r; -- return next row of SELECT
    END LOOP;
    RETURN;
END
$$;


ALTER FUNCTION public.jteste2() OWNER TO postgres;

--
-- Name: jteste3(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION jteste3() RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    r text;
    t text;
    a text;
    b text;
BEGIN
	t:='';
	a:=', $';
	b:='';
    FOR r IN select dynamicproperty from recordleveldynamicproperty rldp left join dynamicproperty d on d.iddynamicproperty = rldp.iddynamicproperty where rldp.idrecordlevelelement=49484

    LOOP
        t := t || r || ', ';
    END LOOP;
    
    RETURN regexp_replace(t,a,b);
END
$_$;


ALTER FUNCTION public.jteste3() OWNER TO postgres;

--
-- Name: jteste3(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION jteste3(text) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    r text;
    t text;
    a text;
    b text;
BEGIN
	t:='';
	a:=', $';
	b:='';
    FOR r IN select $1 from recordleveldynamicproperty rldp left join dynamicproperty d on d.iddynamicproperty = rldp.iddynamicproperty where rldp.idrecordlevelelement=49484

    LOOP
        t := t || r || ', ';
    END LOOP;
    
    RETURN regexp_replace(t,a,b);
END
$_$;


ALTER FUNCTION public.jteste3(text) OWNER TO postgres;

--
-- Name: jteste3(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION jteste3(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    r text;
    t text;
    a text;
    b text;
BEGIN
	t:='';
	a:=', $';
	b:='';
    FOR r IN select dynamicproperty from recordleveldynamicproperty rldp left join dynamicproperty d on d.iddynamicproperty = rldp.iddynamicproperty where rldp.idrecordlevelelement=$1

    LOOP
        t := t || r || ', ';
    END LOOP;
    
    RETURN regexp_replace(t,a,b);
END
$_$;


ALTER FUNCTION public.jteste3(integer) OWNER TO postgres;

--
-- Name: levenshtein(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION levenshtein(text, text) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/fuzzystrmatch', 'levenshtein';


ALTER FUNCTION public.levenshtein(text, text) OWNER TO postgres;

--
-- Name: levenshtein(text, text, integer, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION levenshtein(text, text, integer, integer, integer) RETURNS integer
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/fuzzystrmatch', 'levenshtein_with_costs';


ALTER FUNCTION public.levenshtein(text, text, integer, integer, integer) OWNER TO postgres;

--
-- Name: lockrow(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lockrow(text, text, text) RETURNS integer
    LANGUAGE sql STRICT
    AS $_$ SELECT LockRow(current_schema(), $1, $2, $3, now()::timestamp+'1:00'); $_$;


ALTER FUNCTION public.lockrow(text, text, text) OWNER TO postgres;

--
-- Name: lockrow(text, text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lockrow(text, text, text, text) RETURNS integer
    LANGUAGE sql STRICT
    AS $_$ SELECT LockRow($1, $2, $3, $4, now()::timestamp+'1:00'); $_$;


ALTER FUNCTION public.lockrow(text, text, text, text) OWNER TO postgres;

--
-- Name: lockrow(text, text, text, timestamp without time zone); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lockrow(text, text, text, timestamp without time zone) RETURNS integer
    LANGUAGE sql STRICT
    AS $_$ SELECT LockRow(current_schema(), $1, $2, $3, $4); $_$;


ALTER FUNCTION public.lockrow(text, text, text, timestamp without time zone) OWNER TO postgres;

--
-- Name: lockrow(text, text, text, text, timestamp without time zone); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lockrow(text, text, text, text, timestamp without time zone) RETURNS integer
    LANGUAGE plpgsql STRICT
    AS $_$ 
DECLARE
	myschema alias for $1;
	mytable alias for $2;
	myrid   alias for $3;
	authid alias for $4;
	expires alias for $5;
	ret int;
	mytoid oid;
	myrec RECORD;
	
BEGIN

	IF NOT LongTransactionsEnabled() THEN
		RAISE EXCEPTION 'Long transaction support disabled, use EnableLongTransaction() to enable.';
	END IF;

	EXECUTE 'DELETE FROM authorization_table WHERE expires < now()'; 

	SELECT c.oid INTO mytoid FROM pg_class c, pg_namespace n
		WHERE c.relname = mytable
		AND c.relnamespace = n.oid
		AND n.nspname = myschema;

	-- RAISE NOTICE 'toid: %', mytoid;

	FOR myrec IN SELECT * FROM authorization_table WHERE 
		toid = mytoid AND rid = myrid
	LOOP
		IF myrec.authid != authid THEN
			RETURN 0;
		ELSE
			RETURN 1;
		END IF;
	END LOOP;

	EXECUTE 'INSERT INTO authorization_table VALUES ('||
		quote_literal(mytoid::text)||','||quote_literal(myrid)||
		','||quote_literal(expires::text)||
		','||quote_literal(authid) ||')';

	GET DIAGNOSTICS ret = ROW_COUNT;

	RETURN ret;
END;
$_$;


ALTER FUNCTION public.lockrow(text, text, text, text, timestamp without time zone) OWNER TO postgres;

--
-- Name: longtransactionsenabled(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION longtransactionsenabled() RETURNS boolean
    LANGUAGE plpgsql
    AS $$ 
DECLARE
	rec RECORD;
BEGIN
	FOR rec IN SELECT oid FROM pg_class WHERE relname = 'authorized_tables'
	LOOP
		return 't';
	END LOOP;
	return 'f';
END;
$$;


ALTER FUNCTION public.longtransactionsenabled() OWNER TO postgres;

--
-- Name: metaphone(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION metaphone(text, integer) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/fuzzystrmatch', 'metaphone';


ALTER FUNCTION public.metaphone(text, integer) OWNER TO postgres;

--
-- Name: nnafiliation(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnafiliation(idreferenceelement integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN select afiliation from referenceafiliation rldp left join afiliation d on d.idafiliation = rldp.idafiliation where rldp.idreferenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnafiliation(idreferenceelement integer) OWNER TO postgres;

--
-- Name: nnassociatedsequence(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnassociatedsequence(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN 
    select associatedsequence from occurrenceassociatedsequence a 
    left join associatedsequence d on d.idassociatedsequence = a.idassociatedsequence 
    where a.idoccurrenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnassociatedsequence(integer) OWNER TO postgres;

--
-- Name: nnbiome(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnbiome(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN select biome from referencebiome rldp left join biome d on d.idbiome = rldp.idbiome where rldp.idreferenceelement =$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnbiome(integer) OWNER TO postgres;

--
-- Name: nncreator(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nncreator(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN select creator from referencecreator rldp left join creator d on d.idcreator = rldp.idcreator where rldp.idreferenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nncreator(integer) OWNER TO postgres;

--
-- Name: nndynamic(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nndynamic(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN select dynamicproperty from recordleveldynamicproperty rldp left join dynamicproperty d on d.iddynamicproperty = rldp.iddynamicproperty where rldp.idrecordlevelelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nndynamic(integer) OWNER TO postgres;

--
-- Name: nngeoreferencedby(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nngeoreferencedby(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN 
    select georeferencedby from localitygeoreferencedby a 
    left join georeferencedby d on d.idgeoreferencedby = a.idgeoreferencedby 
    where a.idlocalityelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nngeoreferencedby(integer) OWNER TO postgres;

--
-- Name: nngeoreferencesource(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nngeoreferencesource(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN 
    select georeferencesource from localitygeoreferencesource a 
    left join georeferencesource d on d.idgeoreferencesource = a.idgeoreferencesource 
    where a.idlocalityelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nngeoreferencesource(integer) OWNER TO postgres;

--
-- Name: nnidentifiedby(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnidentifiedby(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN 
    select identifiedby from identificationidentifiedby a 
    left join identifiedby d on d.ididentifiedby = a.ididentifiedby 
    where a.ididentificationelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnidentifiedby(integer) OWNER TO postgres;

--
-- Name: nnindividual(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnindividual(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN 
    select individual from occurrenceindividual a 
    left join individual d on d.idindividual = a.idindividual 
    where a.idoccurrenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnindividual(integer) OWNER TO postgres;

--
-- Name: nnkeyword(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnkeyword(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN select keyword from referencekeyword rldp left join keyword d on d.idkeyword = rldp.idkeyword where rldp.idreferenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnkeyword(integer) OWNER TO postgres;

--
-- Name: nnplantcommonname(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnplantcommonname(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN select plantcommonname from referenceplantcommonname rldp left join plantcommonname d on d.idplantcommonname = rldp.idplantcommonname where rldp.idreferenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnplantcommonname(integer) OWNER TO postgres;

--
-- Name: nnplantfamily(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnplantfamily(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN select plantfamily from referenceplantfamily rldp left join plantfamily d on d.idplantfamily = rldp.idplantfamily where rldp.idreferenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnplantfamily(integer) OWNER TO postgres;

--
-- Name: nnplantspecies(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnplantspecies(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN select plantspecies from referenceplantspecies rldp left join plantspecies d on d.idplantspecies = rldp.idplantspecies where rldp.idreferenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnplantspecies(integer) OWNER TO postgres;

--
-- Name: nnpollinatorcommonname(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnpollinatorcommonname(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN select pollinatorcommonname from referencepollinatorcommonname rldp left join pollinatorcommonname d on d.idpollinatorcommonname = rldp.idpollinatorcommonname where rldp.idreferenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnpollinatorcommonname(integer) OWNER TO postgres;

--
-- Name: nnpollinatorfamily(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnpollinatorfamily(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN select pollinatorfamily from referencepollinatorfamily rldp left join pollinatorfamily d on d.idpollinatorfamily = rldp.idpollinatorfamily where rldp.idreferenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnpollinatorfamily(integer) OWNER TO postgres;

--
-- Name: nnpollinatorspecies(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnpollinatorspecies(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN select pollinatorspecies from referencepollinatorspecies rldp left join pollinatorspecies d on d.idpollinatorspecies = rldp.idpollinatorspecies where rldp.idreferenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnpollinatorspecies(integer) OWNER TO postgres;

--
-- Name: nnpreparation(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnpreparation(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN 
    select preparation from occurrencepreparation a 
    left join preparation d on d.idpreparation = a.idpreparation 
    where a.idoccurrenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnpreparation(integer) OWNER TO postgres;

--
-- Name: nnrecordedby(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nnrecordedby(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN 
    select recordedby from occurrencerecordedby a 
    left join recordedby d on d.idrecordedby = a.idrecordedby 
    where a.idoccurrenceelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nnrecordedby(integer) OWNER TO postgres;

--
-- Name: nntypestatus(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION nntypestatus(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    aux text;
    concatenado text;
    reg_antes text;
    reg_dps text;
BEGIN
	concatenado:='';
	reg_antes:=', $';
	reg_dps:='';
    FOR aux IN 
    select typestatus from identificationtypestatus a 
    left join typestatus d on d.idtypestatus = a.idtypestatus 
    where a.ididentificationelement=$1

    LOOP
        concatenado := concatenado || aux || ', ';
    END LOOP;
    
    RETURN regexp_replace(concatenado,reg_antes,reg_dps);
END
$_$;


ALTER FUNCTION public.nntypestatus(integer) OWNER TO postgres;

--
-- Name: populate_geometry_columns(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION populate_geometry_columns() RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
	inserted    integer;
	oldcount    integer;
	probed      integer;
	stale       integer;
	gcs         RECORD;
	gc          RECORD;
	gsrid       integer;
	gndims      integer;
	gtype       text;
	query       text;
	gc_is_valid boolean;
	
BEGIN
	SELECT count(*) INTO oldcount FROM geometry_columns;
	inserted := 0;

	EXECUTE 'TRUNCATE geometry_columns';

	-- Count the number of geometry columns in all tables and views
	SELECT count(DISTINCT c.oid) INTO probed
	FROM pg_class c, 
	     pg_attribute a, 
	     pg_type t, 
	     pg_namespace n
	WHERE (c.relkind = 'r' OR c.relkind = 'v')
	AND t.typname = 'geometry'
	AND a.attisdropped = false
	AND a.atttypid = t.oid
	AND a.attrelid = c.oid
	AND c.relnamespace = n.oid
	AND n.nspname NOT ILIKE 'pg_temp%';

	-- Iterate through all non-dropped geometry columns
	RAISE DEBUG 'Processing Tables.....';

	FOR gcs IN 
	SELECT DISTINCT ON (c.oid) c.oid, n.nspname, c.relname
	    FROM pg_class c, 
	         pg_attribute a, 
	         pg_type t, 
	         pg_namespace n
	    WHERE c.relkind = 'r'
	    AND t.typname = 'geometry'
	    AND a.attisdropped = false
	    AND a.atttypid = t.oid
	    AND a.attrelid = c.oid
	    AND c.relnamespace = n.oid
	    AND n.nspname NOT ILIKE 'pg_temp%'
	LOOP
	
	inserted := inserted + populate_geometry_columns(gcs.oid);
	END LOOP;
	
	-- Add views to geometry columns table
	RAISE DEBUG 'Processing Views.....';
	FOR gcs IN 
	SELECT DISTINCT ON (c.oid) c.oid, n.nspname, c.relname
	    FROM pg_class c, 
	         pg_attribute a, 
	         pg_type t, 
	         pg_namespace n
	    WHERE c.relkind = 'v'
	    AND t.typname = 'geometry'
	    AND a.attisdropped = false
	    AND a.atttypid = t.oid
	    AND a.attrelid = c.oid
	    AND c.relnamespace = n.oid
	LOOP            
	    
	inserted := inserted + populate_geometry_columns(gcs.oid);
	END LOOP;

	IF oldcount > inserted THEN
	stale = oldcount-inserted;
	ELSE
	stale = 0;
	END IF;

	RETURN 'probed:' ||probed|| ' inserted:'||inserted|| ' conflicts:'||probed-inserted|| ' deleted:'||stale;
END

$$;


ALTER FUNCTION public.populate_geometry_columns() OWNER TO postgres;

--
-- Name: populate_geometry_columns(oid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION populate_geometry_columns(tbl_oid oid) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
	gcs         RECORD;
	gc          RECORD;
	gsrid       integer;
	gndims      integer;
	gtype       text;
	query       text;
	gc_is_valid boolean;
	inserted    integer;
	
BEGIN
	inserted := 0;
	
	-- Iterate through all geometry columns in this table
	FOR gcs IN 
	SELECT n.nspname, c.relname, a.attname
	    FROM pg_class c, 
	         pg_attribute a, 
	         pg_type t, 
	         pg_namespace n
	    WHERE c.relkind = 'r'
	    AND t.typname = 'geometry'
	    AND a.attisdropped = false
	    AND a.atttypid = t.oid
	    AND a.attrelid = c.oid
	    AND c.relnamespace = n.oid
	    AND n.nspname NOT ILIKE 'pg_temp%'
	    AND c.oid = tbl_oid
	LOOP
	
	RAISE DEBUG 'Processing table %.%.%', gcs.nspname, gcs.relname, gcs.attname;

	DELETE FROM geometry_columns 
	  WHERE f_table_schema = quote_ident(gcs.nspname) 
	  AND f_table_name = quote_ident(gcs.relname)
	  AND f_geometry_column = quote_ident(gcs.attname);
	
	gc_is_valid := true;
	
	-- Try to find srid check from system tables (pg_constraint)
	gsrid := 
	    (SELECT replace(replace(split_part(s.consrc, ' = ', 2), ')', ''), '(', '') 
	     FROM pg_class c, pg_namespace n, pg_attribute a, pg_constraint s 
	     WHERE n.nspname = gcs.nspname 
	     AND c.relname = gcs.relname 
	     AND a.attname = gcs.attname 
	     AND a.attrelid = c.oid
	     AND s.connamespace = n.oid
	     AND s.conrelid = c.oid
	     AND a.attnum = ANY (s.conkey)
	     AND s.consrc LIKE '%srid(% = %');
	IF (gsrid IS NULL) THEN 
	    -- Try to find srid from the geometry itself
	    EXECUTE 'SELECT public.srid(' || quote_ident(gcs.attname) || ') 
	             FROM ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	             WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1' 
	        INTO gc;
	    gsrid := gc.srid;
	    
	    -- Try to apply srid check to column
	    IF (gsrid IS NOT NULL) THEN
	        BEGIN
	            EXECUTE 'ALTER TABLE ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	                     ADD CONSTRAINT ' || quote_ident('enforce_srid_' || gcs.attname) || ' 
	                     CHECK (srid(' || quote_ident(gcs.attname) || ') = ' || gsrid || ')';
	        EXCEPTION
	            WHEN check_violation THEN
	                RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not apply constraint CHECK (srid(%) = %)', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname), quote_ident(gcs.attname), gsrid;
	                gc_is_valid := false;
	        END;
	    END IF;
	END IF;
	
	-- Try to find ndims check from system tables (pg_constraint)
	gndims := 
	    (SELECT replace(split_part(s.consrc, ' = ', 2), ')', '') 
	     FROM pg_class c, pg_namespace n, pg_attribute a, pg_constraint s 
	     WHERE n.nspname = gcs.nspname 
	     AND c.relname = gcs.relname 
	     AND a.attname = gcs.attname 
	     AND a.attrelid = c.oid
	     AND s.connamespace = n.oid
	     AND s.conrelid = c.oid
	     AND a.attnum = ANY (s.conkey)
	     AND s.consrc LIKE '%ndims(% = %');
	IF (gndims IS NULL) THEN
	    -- Try to find ndims from the geometry itself
	    EXECUTE 'SELECT public.ndims(' || quote_ident(gcs.attname) || ') 
	             FROM ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	             WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1' 
	        INTO gc;
	    gndims := gc.ndims;
	    
	    -- Try to apply ndims check to column
	    IF (gndims IS NOT NULL) THEN
	        BEGIN
	            EXECUTE 'ALTER TABLE ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	                     ADD CONSTRAINT ' || quote_ident('enforce_dims_' || gcs.attname) || ' 
	                     CHECK (ndims(' || quote_ident(gcs.attname) || ') = '||gndims||')';
	        EXCEPTION
	            WHEN check_violation THEN
	                RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not apply constraint CHECK (ndims(%) = %)', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname), quote_ident(gcs.attname), gndims;
	                gc_is_valid := false;
	        END;
	    END IF;
	END IF;
	
	-- Try to find geotype check from system tables (pg_constraint)
	gtype := 
	    (SELECT replace(split_part(s.consrc, '''', 2), ')', '') 
	     FROM pg_class c, pg_namespace n, pg_attribute a, pg_constraint s 
	     WHERE n.nspname = gcs.nspname 
	     AND c.relname = gcs.relname 
	     AND a.attname = gcs.attname 
	     AND a.attrelid = c.oid
	     AND s.connamespace = n.oid
	     AND s.conrelid = c.oid
	     AND a.attnum = ANY (s.conkey)
	     AND s.consrc LIKE '%geometrytype(% = %');
	IF (gtype IS NULL) THEN
	    -- Try to find geotype from the geometry itself
	    EXECUTE 'SELECT public.geometrytype(' || quote_ident(gcs.attname) || ') 
	             FROM ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	             WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1' 
	        INTO gc;
	    gtype := gc.geometrytype;
	    --IF (gtype IS NULL) THEN
	    --    gtype := 'GEOMETRY';
	    --END IF;
	    
	    -- Try to apply geometrytype check to column
	    IF (gtype IS NOT NULL) THEN
	        BEGIN
	            EXECUTE 'ALTER TABLE ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	            ADD CONSTRAINT ' || quote_ident('enforce_geotype_' || gcs.attname) || ' 
	            CHECK ((geometrytype(' || quote_ident(gcs.attname) || ') = ' || quote_literal(gtype) || ') OR (' || quote_ident(gcs.attname) || ' IS NULL))';
	        EXCEPTION
	            WHEN check_violation THEN
	                -- No geometry check can be applied. This column contains a number of geometry types.
	                RAISE WARNING 'Could not add geometry type check (%) to table column: %.%.%', gtype, quote_ident(gcs.nspname),quote_ident(gcs.relname),quote_ident(gcs.attname);
	        END;
	    END IF;
	END IF;
	        
	IF (gsrid IS NULL) THEN             
	    RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine the srid', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	ELSIF (gndims IS NULL) THEN
	    RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine the number of dimensions', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	ELSIF (gtype IS NULL) THEN
	    RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine the geometry type', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	ELSE
	    -- Only insert into geometry_columns if table constraints could be applied.
	    IF (gc_is_valid) THEN
	        INSERT INTO geometry_columns (f_table_catalog,f_table_schema, f_table_name, f_geometry_column, coord_dimension, srid, type) 
	        VALUES ('', gcs.nspname, gcs.relname, gcs.attname, gndims, gsrid, gtype);
	        inserted := inserted + 1;
	    END IF;
	END IF;
	END LOOP;

	-- Add views to geometry columns table
	FOR gcs IN 
	SELECT n.nspname, c.relname, a.attname
	    FROM pg_class c, 
	         pg_attribute a, 
	         pg_type t, 
	         pg_namespace n
	    WHERE c.relkind = 'v'
	    AND t.typname = 'geometry'
	    AND a.attisdropped = false
	    AND a.atttypid = t.oid
	    AND a.attrelid = c.oid
	    AND c.relnamespace = n.oid
	    AND n.nspname NOT ILIKE 'pg_temp%'
	    AND c.oid = tbl_oid
	LOOP            
	    RAISE DEBUG 'Processing view %.%.%', gcs.nspname, gcs.relname, gcs.attname;

	    EXECUTE 'SELECT public.ndims(' || quote_ident(gcs.attname) || ') 
	             FROM ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	             WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1' 
	        INTO gc;
	    gndims := gc.ndims;
	    
	    EXECUTE 'SELECT public.srid(' || quote_ident(gcs.attname) || ') 
	             FROM ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	             WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1' 
	        INTO gc;
	    gsrid := gc.srid;
	    
	    EXECUTE 'SELECT public.geometrytype(' || quote_ident(gcs.attname) || ') 
	             FROM ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || ' 
	             WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1' 
	        INTO gc;
	    gtype := gc.geometrytype;
	    
	    IF (gndims IS NULL) THEN
	        RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine ndims', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	    ELSIF (gsrid IS NULL) THEN
	        RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine srid', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	    ELSIF (gtype IS NULL) THEN
	        RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine gtype', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	    ELSE
	        query := 'INSERT INTO geometry_columns (f_table_catalog,f_table_schema, f_table_name, f_geometry_column, coord_dimension, srid, type) ' ||
	                 'VALUES ('''', ' || quote_literal(gcs.nspname) || ',' || quote_literal(gcs.relname) || ',' || quote_literal(gcs.attname) || ',' || gndims || ',' || gsrid || ',' || quote_literal(gtype) || ')';
	        EXECUTE query;
	        inserted := inserted + 1;
	    END IF;
	END LOOP;
	
	RETURN inserted;
END

$$;


ALTER FUNCTION public.populate_geometry_columns(tbl_oid oid) OWNER TO postgres;

--
-- Name: postgis_full_version(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_full_version() RETURNS text
    LANGUAGE plpgsql IMMUTABLE
    AS $$ 
DECLARE
	libver text;
	projver text;
	geosver text;
	usestats bool;
	dbproc text;
	relproc text;
	fullver text;
BEGIN
	SELECT postgis_lib_version() INTO libver;
	SELECT postgis_proj_version() INTO projver;
	SELECT postgis_geos_version() INTO geosver;
	SELECT postgis_uses_stats() INTO usestats;
	SELECT postgis_scripts_installed() INTO dbproc;
	SELECT postgis_scripts_released() INTO relproc;

	fullver = 'POSTGIS="' || libver || '"';

	IF  geosver IS NOT NULL THEN
		fullver = fullver || ' GEOS="' || geosver || '"';
	END IF;

	IF  projver IS NOT NULL THEN
		fullver = fullver || ' PROJ="' || projver || '"';
	END IF;

	IF usestats THEN
		fullver = fullver || ' USE_STATS';
	END IF;

	-- fullver = fullver || ' DBPROC="' || dbproc || '"';
	-- fullver = fullver || ' RELPROC="' || relproc || '"';

	IF dbproc != relproc THEN
		fullver = fullver || ' (procs from ' || dbproc || ' need upgrade)';
	END IF;

	RETURN fullver;
END
$$;


ALTER FUNCTION public.postgis_full_version() OWNER TO postgres;

--
-- Name: postgis_scripts_build_date(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_scripts_build_date() RETURNS text
    LANGUAGE sql IMMUTABLE
    AS $$SELECT '2009-12-22 06:47:02'::text AS version$$;


ALTER FUNCTION public.postgis_scripts_build_date() OWNER TO postgres;

--
-- Name: postgis_scripts_installed(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_scripts_installed() RETURNS text
    LANGUAGE sql IMMUTABLE
    AS $$SELECT '1.4.0'::text AS version$$;


ALTER FUNCTION public.postgis_scripts_installed() OWNER TO postgres;

--
-- Name: probe_geometry_columns(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION probe_geometry_columns() RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
	inserted integer;
	oldcount integer;
	probed integer;
	stale integer;
BEGIN

	SELECT count(*) INTO oldcount FROM geometry_columns;

	SELECT count(*) INTO probed
		FROM pg_class c, pg_attribute a, pg_type t, 
			pg_namespace n,
			pg_constraint sridcheck, pg_constraint typecheck

		WHERE t.typname = 'geometry'
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND sridcheck.connamespace = n.oid
		AND typecheck.connamespace = n.oid
		AND sridcheck.conrelid = c.oid
		AND sridcheck.consrc LIKE '(srid('||a.attname||') = %)'
		AND typecheck.conrelid = c.oid
		AND typecheck.consrc LIKE
		'((geometrytype('||a.attname||') = ''%''::text) OR (% IS NULL))'
		;

	INSERT INTO geometry_columns SELECT
		''::varchar as f_table_catalogue,
		n.nspname::varchar as f_table_schema,
		c.relname::varchar as f_table_name,
		a.attname::varchar as f_geometry_column,
		2 as coord_dimension,
		trim(both  ' =)' from 
			replace(replace(split_part(
				sridcheck.consrc, ' = ', 2), ')', ''), '(', ''))::integer AS srid,
		trim(both ' =)''' from substr(typecheck.consrc, 
			strpos(typecheck.consrc, '='),
			strpos(typecheck.consrc, '::')-
			strpos(typecheck.consrc, '=')
			))::varchar as type
		FROM pg_class c, pg_attribute a, pg_type t, 
			pg_namespace n,
			pg_constraint sridcheck, pg_constraint typecheck
		WHERE t.typname = 'geometry'
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND sridcheck.connamespace = n.oid
		AND typecheck.connamespace = n.oid
		AND sridcheck.conrelid = c.oid
		AND sridcheck.consrc LIKE '(st_srid('||a.attname||') = %)'
		AND typecheck.conrelid = c.oid
		AND typecheck.consrc LIKE
		'((geometrytype('||a.attname||') = ''%''::text) OR (% IS NULL))'

	        AND NOT EXISTS (
	                SELECT oid FROM geometry_columns gc
	                WHERE c.relname::varchar = gc.f_table_name
	                AND n.nspname::varchar = gc.f_table_schema
	                AND a.attname::varchar = gc.f_geometry_column
	        );

	GET DIAGNOSTICS inserted = ROW_COUNT;

	IF oldcount > probed THEN
		stale = oldcount-probed;
	ELSE
		stale = 0;
	END IF;

	RETURN 'probed:'||probed::text||
		' inserted:'||inserted::text||
		' conflicts:'||(probed-inserted)::text||
		' stale:'||stale::text;
END

$$;


ALTER FUNCTION public.probe_geometry_columns() OWNER TO postgres;

--
-- Name: rename_geometry_table_constraints(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION rename_geometry_table_constraints() RETURNS text
    LANGUAGE sql IMMUTABLE
    AS $$
SELECT 'rename_geometry_table_constraint() is obsoleted'::text
$$;


ALTER FUNCTION public.rename_geometry_table_constraints() OWNER TO postgres;

--
-- Name: savegeospatial_monitoring(numeric, numeric, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION savegeospatial_monitoring(numeric, numeric, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO geospatialelement(decimallatitude, decimallongitude, geodeticdatum, referencepoints) VALUES ('||$1||', '||$2||', '''||$3||''', '''||$4||''') RETURNING idgeospatialelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.savegeospatial_monitoring(numeric, numeric, text, text) OWNER TO postgres;

--
-- Name: savegeospatial_monitoring(text, text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION savegeospatial_monitoring(text, text, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO geospatialelement(decimallatitude, decimallongitude, geodeticdatum, referencepoints) VALUES ('||$1||', '||$2||', '''||$3||''', '''||$4||''') RETURNING idgeospatialelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.savegeospatial_monitoring(text, text, text, text) OWNER TO postgres;

--
-- Name: savegeospatial_monitoring_t1(numeric, numeric, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION savegeospatial_monitoring_t1(numeric, numeric, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    id:= EXECUTE 'INSERT INTO geospatialelement(decimallatitude, decimallongitude, geodeticdatum, referencepoints) VALUES ('||$1||', '||$2||', '''||$3||''', '''||$4||''') RETURNING idgeospatialelement';
    RETURN id;
END
$_$;


ALTER FUNCTION public.savegeospatial_monitoring_t1(numeric, numeric, text, text) OWNER TO postgres;

--
-- Name: savegeospatial_monitoring_t2(numeric, numeric, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION savegeospatial_monitoring_t2(numeric, numeric, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    id:= execute 'INSERT INTO geospatialelement(decimallatitude, decimallongitude, geodeticdatum, referencepoints) VALUES ('||$1||', '||$2||', '''||$3||''', '''||$4||''') RETURNING idgeospatialelement';
    RETURN id;
END;
$_$;


ALTER FUNCTION public.savegeospatial_monitoring_t2(numeric, numeric, text, text) OWNER TO postgres;

--
-- Name: savegeospatial_monitoring_t3(numeric, numeric, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION savegeospatial_monitoring_t3(numeric, numeric, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO geospatialelement(decimallatitude, decimallongitude, geodeticdatum, referencepoints) VALUES ('||$1||', '||$2||', '''||$3||''', '''||$4||''') RETURNING idgeospatialelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.savegeospatial_monitoring_t3(numeric, numeric, text, text) OWNER TO postgres;

--
-- Name: savelocality_monitoring(text, integer, integer, text, integer, integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION savelocality_monitoring(text, integer, integer, text, integer, integer, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO localityelement(coordinateprecision, idcountry, idlocality, locationremark, idmunicipality, idstateprovince, verbatimelevation) VALUES ('''||$1||''', '||$2||', '||$3||', '''||$4||''', '||$5||', '||$6||', '''||$7||''') RETURNING idlocalityelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.savelocality_monitoring(text, integer, integer, text, integer, integer, text) OWNER TO postgres;

--
-- Name: savelocality_monitoring(text, text, text, text, text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION savelocality_monitoring(text, text, text, text, text, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO localityelement(coordinateprecision, idcountry, idlocality, locationremark, idmunicipality, idstateprovince, verbatimelevation) VALUES ('''||$1||''', '||$2||', '||$3||', '''||$4||''', '||$5||', '||$6||', '''||$7||''') RETURNING idlocalityelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.savelocality_monitoring(text, text, text, text, text, text, text) OWNER TO postgres;

--
-- Name: saveoccurrence_monitoring(integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION saveoccurrence_monitoring(integer, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO occurrenceelement(idsex, catalognumber) VALUES ('||$1||', '''||$2||''') RETURNING idoccurrenceelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.saveoccurrence_monitoring(integer, text) OWNER TO postgres;

--
-- Name: saveoccurrence_monitoring(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION saveoccurrence_monitoring(text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO occurrenceelement(idsex, catalognumber) VALUES ('||$1||', '''||$2||''') RETURNING idoccurrenceelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.saveoccurrence_monitoring(text, text) OWNER TO postgres;

--
-- Name: saverecordlevel_monitoring(date, numeric, numeric, numeric); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION saverecordlevel_monitoring(date, numeric, numeric, numeric) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO recordlevelelement(modified, idinstitutioncode, idcollectioncode, idbasisofrecord) VALUES ('''||$1||''', '||$2||', '||$3||', '||$4||') RETURNING idrecordlevelelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.saverecordlevel_monitoring(date, numeric, numeric, numeric) OWNER TO postgres;

--
-- Name: saverecordlevel_monitoring(text, text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION saverecordlevel_monitoring(text, text, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO recordlevelelement(modified, idinstitutioncode, idcollectioncode, idbasisofrecord, globaluniqueidentifier) VALUES ('''||$1||''', '||$2||', '||$3||', '||$4||', '''||$4||''') RETURNING idrecordlevelelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.saverecordlevel_monitoring(text, text, text, text) OWNER TO postgres;

--
-- Name: saverecordlevel_monitoring(text, text, text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION saverecordlevel_monitoring(text, text, text, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO recordlevelelement(modified, idinstitutioncode, idcollectioncode, idbasisofrecord, globaluniqueidentifier) VALUES ('''||$1||''', '||$2||', '||$3||', '||$4||', '''||$5||''') RETURNING idrecordlevelelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.saverecordlevel_monitoring(text, text, text, text, text) OWNER TO postgres;

--
-- Name: savetaxonomic_monitoring(integer, integer, integer, integer, integer, integer, integer, integer, integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION savetaxonomic_monitoring(integer, integer, integer, integer, integer, integer, integer, integer, integer, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO taxonomicelement(idfamily, idgenus, idorder, idscientificname, idspeciesname, idsubgenus, idsubtribe, idtribe, idsubspecies, vernacularname) VALUES ('||$1||', '||$2||', '||$3||', '||$4||', '||$5||', '||$6||', '||$7||', '||$8||', '||$9||', '''||$10||''') RETURNING idtaxonomicelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.savetaxonomic_monitoring(integer, integer, integer, integer, integer, integer, integer, integer, integer, text) OWNER TO postgres;

--
-- Name: savetaxonomic_monitoring(text, text, text, text, text, text, text, text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION savetaxonomic_monitoring(text, text, text, text, text, text, text, text, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO taxonomicelement(idfamily, idgenus, idorder, idscientificname, idspeciesname, idsubgenus, idsubtribe, idtribe, idsubspecies, vernacularname) VALUES ('||$1||', '||$2||', '||$3||', '||$4||', '||$5||', '||$6||', '||$7||', '||$8||', '||$9||', '''||$10||''') RETURNING idtaxonomicelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.savetaxonomic_monitoring(text, text, text, text, text, text, text, text, text, text) OWNER TO postgres;

--
-- Name: savetaxonomic_monitoring(text, text, text, text, text, text, text, text, text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION savetaxonomic_monitoring(text, text, text, text, text, text, text, text, text, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'INSERT INTO taxonomicelement(idfamily, idgenus, idorder, idscientificname, idspeciesname, idsubgenus, idsubtribe, idtribe, idsubspecies, vernacularname, higherclassification) VALUES ('||$1||', '||$2||', '||$3||', '||$4||', '||$5||', '||$6||', '||$7||', '||$8||', '||$9||', '''||$10||''', '''||$11||''') RETURNING idtaxonomicelement' into id;
    RETURN id;
END;
$_$;


ALTER FUNCTION public.savetaxonomic_monitoring(text, text, text, text, text, text, text, text, text, text, text) OWNER TO postgres;

--
-- Name: soundex(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION soundex(text) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/fuzzystrmatch', 'soundex';


ALTER FUNCTION public.soundex(text) OWNER TO postgres;

--
-- Name: text_soundex(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION text_soundex(text) RETURNS text
    LANGUAGE c IMMUTABLE STRICT
    AS '$libdir/fuzzystrmatch', 'soundex';


ALTER FUNCTION public.text_soundex(text) OWNER TO postgres;

--
-- Name: unlockrows(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION unlockrows(text) RETURNS integer
    LANGUAGE plpgsql STRICT
    AS $_$ 
DECLARE
	ret int;
BEGIN

	IF NOT LongTransactionsEnabled() THEN
		RAISE EXCEPTION 'Long transaction support disabled, use EnableLongTransaction() to enable.';
	END IF;

	EXECUTE 'DELETE FROM authorization_table where authid = ' ||
		quote_literal($1);

	GET DIAGNOSTICS ret = ROW_COUNT;

	RETURN ret;
END;
$_$;


ALTER FUNCTION public.unlockrows(text) OWNER TO postgres;

--
-- Name: update_geometry_stats(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION update_geometry_stats() RETURNS text
    LANGUAGE sql
    AS $$ SELECT 'update_geometry_stats() has been obsoleted. Statistics are automatically built running the ANALYZE command'::text$$;


ALTER FUNCTION public.update_geometry_stats() OWNER TO postgres;

--
-- Name: update_geometry_stats(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION update_geometry_stats(character varying, character varying) RETURNS text
    LANGUAGE sql
    AS $$SELECT update_geometry_stats();$$;


ALTER FUNCTION public.update_geometry_stats(character varying, character varying) OWNER TO postgres;

--
-- Name: updategeometrysrid(character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updategeometrysrid(character varying, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$ 
DECLARE
	ret  text;
BEGIN
	SELECT UpdateGeometrySRID('','',$1,$2,$3) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.updategeometrysrid(character varying, character varying, integer) OWNER TO postgres;

--
-- Name: updategeometrysrid(character varying, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updategeometrysrid(character varying, character varying, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$ 
DECLARE
	ret  text;
BEGIN
	SELECT UpdateGeometrySRID('',$1,$2,$3,$4) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.updategeometrysrid(character varying, character varying, character varying, integer) OWNER TO postgres;

--
-- Name: updategeometrysrid(character varying, character varying, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updategeometrysrid(character varying, character varying, character varying, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1; 
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	new_srid alias for $5;
	myrec RECORD;
	okay boolean;
	cname varchar;
	real_schema name;

BEGIN


	-- Find, check or fix schema_name
	IF ( schema_name != '' ) THEN
		okay = 'f';

		FOR myrec IN SELECT nspname FROM pg_namespace WHERE text(nspname) = schema_name LOOP
			okay := 't';
		END LOOP;

		IF ( okay <> 't' ) THEN
			RAISE EXCEPTION 'Invalid schema name';
		ELSE
			real_schema = schema_name;
		END IF;
	ELSE
		SELECT INTO real_schema current_schema()::text;
	END IF;

 	-- Find out if the column is in the geometry_columns table
	okay = 'f';
	FOR myrec IN SELECT * from geometry_columns where f_table_schema = text(real_schema) and f_table_name = table_name and f_geometry_column = column_name LOOP
		okay := 't';
	END LOOP; 
	IF (okay <> 't') THEN 
		RAISE EXCEPTION 'column not found in geometry_columns table';
		RETURN 'f';
	END IF;

	-- Update ref from geometry_columns table
	EXECUTE 'UPDATE geometry_columns SET SRID = ' || new_srid::text || 
		' where f_table_schema = ' ||
		quote_literal(real_schema) || ' and f_table_name = ' ||
		quote_literal(table_name)  || ' and f_geometry_column = ' ||
		quote_literal(column_name);
	
	-- Make up constraint name
	cname = 'enforce_srid_'  || column_name;

	-- Drop enforce_srid constraint
	EXECUTE 'ALTER TABLE ' || quote_ident(real_schema) ||
		'.' || quote_ident(table_name) ||
		' DROP constraint ' || quote_ident(cname);

	-- Update geometries SRID
	EXECUTE 'UPDATE ' || quote_ident(real_schema) ||
		'.' || quote_ident(table_name) ||
		' SET ' || quote_ident(column_name) ||
		' = setSRID(' || quote_ident(column_name) ||
		', ' || new_srid::text || ')';

	-- Reset enforce_srid constraint
	EXECUTE 'ALTER TABLE ' || quote_ident(real_schema) ||
		'.' || quote_ident(table_name) ||
		' ADD constraint ' || quote_ident(cname) ||
		' CHECK (srid(' || quote_ident(column_name) ||
		') = ' || new_srid::text || ')';

	RETURN real_schema || '.' || table_name || '.' || column_name ||' SRID changed to ' || new_srid::text;
	
END;
$_$;


ALTER FUNCTION public.updategeometrysrid(character varying, character varying, character varying, character varying, integer) OWNER TO postgres;

--
-- Name: updategeospatial_monitoring(numeric, numeric, text, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updategeospatial_monitoring(numeric, numeric, text, text, integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'UPDATE geospatialelement SET decimallatitude ='||$1||', decimallongitude ='||$2||', geodeticdatum= '''||$3||''', referencepoints ='''||$4||''' WHERE idgeospatialelement = '||$5||';';
    RETURN $5;
END;
$_$;


ALTER FUNCTION public.updategeospatial_monitoring(numeric, numeric, text, text, integer) OWNER TO postgres;

--
-- Name: updategeospatial_monitoring(text, text, text, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updategeospatial_monitoring(text, text, text, text, integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'UPDATE geospatialelement SET decimallatitude ='||$1||', decimallongitude ='||$2||', geodeticdatum= '''||$3||''', referencepoints ='''||$4||''' WHERE idgeospatialelement = '||$5||';';
    RETURN $5;
END;
$_$;


ALTER FUNCTION public.updategeospatial_monitoring(text, text, text, text, integer) OWNER TO postgres;

--
-- Name: updatelocality_monitoring(text, integer, integer, text, integer, integer, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updatelocality_monitoring(text, integer, integer, text, integer, integer, text, integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
   
BEGIN
    execute 'SET coordinateprecision = '''||$1||''', idcountry = '||$2||', idlocality = '||$3||', locationremark = '''||$4||''', idmunicipality = '||$5||', idstateprovince = '||$6||', verbatimelevation = '''||$7||''' WHERE idlocalityelement = '||$8||';';
    RETURN $8;
END;
$_$;


ALTER FUNCTION public.updatelocality_monitoring(text, integer, integer, text, integer, integer, text, integer) OWNER TO postgres;

--
-- Name: updatelocality_monitoring(text, text, text, text, text, text, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updatelocality_monitoring(text, text, text, text, text, text, text, integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
   
BEGIN
    execute 'UPDATE localityelement SET coordinateprecision = '''||$1||''', idcountry = '||$2||', idlocality = '||$3||', locationremark = '''||$4||''', idmunicipality = '||$5||', idstateprovince = '||$6||', verbatimelevation = '''||$7||''' WHERE idlocalityelement = '||$8||';';
    RETURN $8;
END;
$_$;


ALTER FUNCTION public.updatelocality_monitoring(text, text, text, text, text, text, text, integer) OWNER TO postgres;

--
-- Name: updateoccurrence_monitoring(text, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updateoccurrence_monitoring(text, text, integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'UPDATE occurrenceelement SET idsex = '||$1||', catalognumber = '''||$2||'''  WHERE idoccurrenceelement = '||$3;
    RETURN $3;
END;
$_$;


ALTER FUNCTION public.updateoccurrence_monitoring(text, text, integer) OWNER TO postgres;

--
-- Name: updaterecordlevel_monitoring(text, text, text, text, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updaterecordlevel_monitoring(text, text, text, text, text, integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'UPDATE recordlevelelement SET modified = '''||$1||''', idinstitutioncode = '||$2||', idcollectioncode = '||$3||',  idbasisofrecord = '||$4||', globaluniqueidentifier = '''||$5||''' WHERE idrecordlevelelement='||$6;
    RETURN $6;
END;
$_$;


ALTER FUNCTION public.updaterecordlevel_monitoring(text, text, text, text, text, integer) OWNER TO postgres;

--
-- Name: updatetaxonomic_monitoring(text, text, text, text, text, text, text, text, text, text, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updatetaxonomic_monitoring(text, text, text, text, text, text, text, text, text, text, text, integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    id integer;
BEGIN
    execute 'UPDATE taxonomicelement SET idfamily = '||$1||', idgenus = '||$2||', idorder = '||$3||', idscientificname = '||$4||', idspeciesname = '||$5||', idsubgenus = '||$6||', idsubtribe = '||$7||', idtribe = '||$8||', idsubspecies = '||$9||', vernacularname = '''||$10||''', higherclassification = '''||$11||''' WHERE idtaxonomicelement = '||$12;
    RETURN $12;
END;
$_$;


ALTER FUNCTION public.updatetaxonomic_monitoring(text, text, text, text, text, text, text, text, text, text, text, integer) OWNER TO postgres;

--
-- Name: ActiveRecordLog; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "ActiveRecordLog" (
    description character varying(255) DEFAULT NULL::character varying,
    action character varying(20) DEFAULT NULL::character varying,
    model character varying(45) DEFAULT NULL::character varying,
    "idModel" integer,
    field character varying(45) DEFAULT NULL::character varying,
    creationdate timestamp without time zone NOT NULL,
    userid character varying(45) DEFAULT NULL::character varying
);


ALTER TABLE public."ActiveRecordLog" OWNER TO postgres;

--
-- Name: afiliation; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE afiliation (
    idafiliation integer NOT NULL,
    afiliation character varying
);


ALTER TABLE public.afiliation OWNER TO postgres;

--
-- Name: Afiliation_idafiliation_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Afiliation_idafiliation_seq"
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."Afiliation_idafiliation_seq" OWNER TO postgres;

--
-- Name: Afiliation_idafiliation_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Afiliation_idafiliation_seq" OWNED BY afiliation.idafiliation;


--
-- Name: acceptednameusage; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE acceptednameusage (
    idacceptednameusage integer NOT NULL,
    acceptednameusage character varying(120)
);


ALTER TABLE public.acceptednameusage OWNER TO postgres;

--
-- Name: acceptednameusage_idacceptednameusage_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE acceptednameusage_idacceptednameusage_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.acceptednameusage_idacceptednameusage_seq OWNER TO postgres;

--
-- Name: acceptednameusage_idacceptednameusage_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE acceptednameusage_idacceptednameusage_seq OWNED BY acceptednameusage.idacceptednameusage;


--
-- Name: accrualmethod; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE accrualmethod (
    idaccrualmethod integer NOT NULL,
    accrualmethod character varying(100)
);


ALTER TABLE public.accrualmethod OWNER TO postgres;

--
-- Name: accrualperiodicity; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE accrualperiodicity (
    idaccrualperiodicity integer NOT NULL,
    accrualperiodicity character varying(100)
);


ALTER TABLE public.accrualperiodicity OWNER TO postgres;

--
-- Name: accrualpolicy; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE accrualpolicy (
    idaccrualpolicy integer NOT NULL,
    accrualpolicy character varying(100)
);


ALTER TABLE public.accrualpolicy OWNER TO postgres;

--
-- Name: accuralmethods_idaccuralmethods_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE accuralmethods_idaccuralmethods_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.accuralmethods_idaccuralmethods_seq OWNER TO postgres;

--
-- Name: accuralmethods_idaccuralmethods_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE accuralmethods_idaccuralmethods_seq OWNED BY accrualmethod.idaccrualmethod;


--
-- Name: accuralperiodicities_idaccuralperiodicities_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE accuralperiodicities_idaccuralperiodicities_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.accuralperiodicities_idaccuralperiodicities_seq OWNER TO postgres;

--
-- Name: accuralperiodicities_idaccuralperiodicities_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE accuralperiodicities_idaccuralperiodicities_seq OWNED BY accrualperiodicity.idaccrualperiodicity;


--
-- Name: accuralpolicies_idaccuralpolicies_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE accuralpolicies_idaccuralpolicies_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.accuralpolicies_idaccuralpolicies_seq OWNER TO postgres;

--
-- Name: accuralpolicies_idaccuralpolicies_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE accuralpolicies_idaccuralpolicies_seq OWNED BY accrualpolicy.idaccrualpolicy;


--
-- Name: annualcycle; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE annualcycle (
    idannualcycle integer NOT NULL,
    annualcycle character varying(50)
);


ALTER TABLE public.annualcycle OWNER TO postgres;

--
-- Name: annualcycle_idannualcycle_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE annualcycle_idannualcycle_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.annualcycle_idannualcycle_seq OWNER TO postgres;

--
-- Name: annualcycle_idannualcycle_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE annualcycle_idannualcycle_seq OWNED BY annualcycle.idannualcycle;


--
-- Name: associatedmedia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE associatedmedia (
    idmedia integer NOT NULL,
    idoccurrenceelements integer NOT NULL
);


ALTER TABLE public.associatedmedia OWNER TO postgres;

--
-- Name: associatedoccurrence; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE associatedoccurrence (
    idoccurrenceelements integer NOT NULL,
    idassociatedoccurrence integer NOT NULL
);


ALTER TABLE public.associatedoccurrence OWNER TO postgres;

--
-- Name: associatedoccurrencecuratorial; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE associatedoccurrencecuratorial (
    idcuratorialelements integer NOT NULL,
    idoccurrenceelements integer NOT NULL
);


ALTER TABLE public.associatedoccurrencecuratorial OWNER TO postgres;

--
-- Name: associatedreferences; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE associatedreferences (
    idreferenceselements integer NOT NULL,
    idoccurrenceelements integer NOT NULL
);


ALTER TABLE public.associatedreferences OWNER TO postgres;

--
-- Name: associatedsequence; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE associatedsequence (
    idassociatedsequence integer NOT NULL,
    associatedsequence text
);


ALTER TABLE public.associatedsequence OWNER TO postgres;

--
-- Name: associatedsequence_idassociatedsequence_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE associatedsequence_idassociatedsequence_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.associatedsequence_idassociatedsequence_seq OWNER TO postgres;

--
-- Name: associatedsequence_idassociatedsequence_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE associatedsequence_idassociatedsequence_seq OWNED BY associatedsequence.idassociatedsequence;


--
-- Name: associatedtaxa; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE associatedtaxa (
    idoccurrenceelements integer NOT NULL,
    idtaxonomicelements integer NOT NULL
);


ALTER TABLE public.associatedtaxa OWNER TO postgres;

--
-- Name: attributes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE attributes (
    idattributes integer NOT NULL,
    attribute text NOT NULL,
    description text NOT NULL
);


ALTER TABLE public.attributes OWNER TO postgres;

--
-- Name: attribute_idAttribute_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "attribute_idAttribute_seq"
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."attribute_idAttribute_seq" OWNER TO postgres;

--
-- Name: attribute_idAttribute_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "attribute_idAttribute_seq" OWNED BY attributes.idattributes;


--
-- Name: audience; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE audience (
    idaudience integer NOT NULL,
    audience character varying(100)
);


ALTER TABLE public.audience OWNER TO postgres;

--
-- Name: audiences_idaudiences_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE audiences_idaudiences_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.audiences_idaudiences_seq OWNER TO postgres;

--
-- Name: audiences_idaudiences_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE audiences_idaudiences_seq OWNED BY audience.idaudience;


--
-- Name: basisofrecord; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE basisofrecord (
    idbasisofrecord integer NOT NULL,
    basisofrecord text NOT NULL
);


ALTER TABLE public.basisofrecord OWNER TO postgres;

--
-- Name: basisofrecords_idbasisofrecord_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE basisofrecords_idbasisofrecord_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.basisofrecords_idbasisofrecord_seq OWNER TO postgres;

--
-- Name: basisofrecords_idbasisofrecord_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE basisofrecords_idbasisofrecord_seq OWNED BY basisofrecord.idbasisofrecord;


--
-- Name: behavior; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE behavior (
    idbehavior integer NOT NULL,
    behavior text
);


ALTER TABLE public.behavior OWNER TO postgres;

--
-- Name: behavior_idbehavior_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE behavior_idbehavior_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.behavior_idbehavior_seq OWNER TO postgres;

--
-- Name: behavior_idbehavior_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE behavior_idbehavior_seq OWNED BY behavior.idbehavior;


--
-- Name: biome; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE biome (
    idbiome integer NOT NULL,
    biome character varying
);


ALTER TABLE public.biome OWNER TO postgres;

--
-- Name: biome_idbiome_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE biome_idbiome_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.biome_idbiome_seq OWNER TO postgres;

--
-- Name: biome_idbiome_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE biome_idbiome_seq OWNED BY biome.idbiome;


--
-- Name: canonicalauthorship; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE canonicalauthorship (
    idcanonicalauthorship integer NOT NULL,
    canonicalauthorship character varying(100) NOT NULL
);


ALTER TABLE public.canonicalauthorship OWNER TO postgres;

--
-- Name: canonicalauthorship_idcanonicalauthorship_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE canonicalauthorship_idcanonicalauthorship_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.canonicalauthorship_idcanonicalauthorship_seq OWNER TO postgres;

--
-- Name: canonicalauthorship_idcanonicalauthorship_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE canonicalauthorship_idcanonicalauthorship_seq OWNED BY canonicalauthorship.idcanonicalauthorship;


--
-- Name: canonicalname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE canonicalname (
    idcanonicalname integer NOT NULL,
    idcanonicalauthorship integer,
    canonicalname integer
);


ALTER TABLE public.canonicalname OWNER TO postgres;

--
-- Name: canonicalnames_idcanonicalnames_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE canonicalnames_idcanonicalnames_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.canonicalnames_idcanonicalnames_seq OWNER TO postgres;

--
-- Name: canonicalnames_idcanonicalnames_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE canonicalnames_idcanonicalnames_seq OWNED BY canonicalname.idcanonicalname;


--
-- Name: capturedevice; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE capturedevice (
    idcapturedevice integer NOT NULL,
    capturedevice character varying(50)
);


ALTER TABLE public.capturedevice OWNER TO postgres;

--
-- Name: capturedevice_idcapturedevice_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE capturedevice_idcapturedevice_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.capturedevice_idcapturedevice_seq OWNER TO postgres;

--
-- Name: capturedevice_idcapturedevice_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE capturedevice_idcapturedevice_seq OWNED BY capturedevice.idcapturedevice;


--
-- Name: categorymedia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE categorymedia (
    idcategorymedia integer NOT NULL,
    categorymedia character varying(128) NOT NULL
);


ALTER TABLE public.categorymedia OWNER TO postgres;

--
-- Name: categorymedia_idcategorymedia_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE categorymedia_idcategorymedia_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.categorymedia_idcategorymedia_seq OWNER TO postgres;

--
-- Name: categorymedia_idcategorymedia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE categorymedia_idcategorymedia_seq OWNED BY categorymedia.idcategorymedia;


--
-- Name: categoryreference; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE categoryreference (
    idcategoryreference integer NOT NULL,
    categoryreference character varying(64) NOT NULL
);


ALTER TABLE public.categoryreference OWNER TO postgres;

--
-- Name: categoryreference_idcategoryreference_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE categoryreference_idcategoryreference_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.categoryreference_idcategoryreference_seq OWNER TO postgres;

--
-- Name: categoryreference_idcategoryreference_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE categoryreference_idcategoryreference_seq OWNED BY categoryreference.idcategoryreference;


--
-- Name: class; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE class (
    idclass integer NOT NULL,
    class text NOT NULL,
    colvalidation boolean DEFAULT false
);


ALTER TABLE public.class OWNER TO postgres;

--
-- Name: classes_idclass_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE classes_idclass_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.classes_idclass_seq OWNER TO postgres;

--
-- Name: classes_idclass_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE classes_idclass_seq OWNED BY class.idclass;


--
-- Name: collectedby; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE collectedby (
    idcollectedby integer NOT NULL,
    collectedby text NOT NULL
);


ALTER TABLE public.collectedby OWNER TO postgres;

--
-- Name: collectioncode; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE collectioncode (
    idcollectioncode integer NOT NULL,
    collectioncode text NOT NULL
);


ALTER TABLE public.collectioncode OWNER TO postgres;

--
-- Name: collectioncodes_idcollectioncode_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE collectioncodes_idcollectioncode_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.collectioncodes_idcollectioncode_seq OWNER TO postgres;

--
-- Name: collectioncodes_idcollectioncode_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE collectioncodes_idcollectioncode_seq OWNED BY collectioncode.idcollectioncode;


--
-- Name: collector; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE collector (
    idcollector integer NOT NULL,
    collector character varying
);


ALTER TABLE public.collector OWNER TO postgres;

--
-- Name: collector_idcollector_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE collector_idcollector_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.collector_idcollector_seq OWNER TO postgres;

--
-- Name: collector_idcollector_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE collector_idcollector_seq OWNED BY collector.idcollector;


--
-- Name: colorpantrap; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE colorpantrap (
    idcolorpantrap integer NOT NULL,
    colorpantrap character varying
);


ALTER TABLE public.colorpantrap OWNER TO postgres;

--
-- Name: colorpantrap_idcolorpantrap_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE colorpantrap_idcolorpantrap_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.colorpantrap_idcolorpantrap_seq OWNER TO postgres;

--
-- Name: colorpantrap_idcolorpantrap_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE colorpantrap_idcolorpantrap_seq OWNED BY colorpantrap.idcolorpantrap;


--
-- Name: commonname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE commonname (
    idcommonname integer NOT NULL,
    commonname character varying(50)
);


ALTER TABLE public.commonname OWNER TO postgres;

--
-- Name: commonnamefocalcrop; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE commonnamefocalcrop (
    idcommonnamefocalcrop integer NOT NULL,
    commonnamefocalcrop character varying
);


ALTER TABLE public.commonnamefocalcrop OWNER TO postgres;

--
-- Name: commonnamefocalcrop_idcommonnamefocalcrop_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE commonnamefocalcrop_idcommonnamefocalcrop_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.commonnamefocalcrop_idcommonnamefocalcrop_seq OWNER TO postgres;

--
-- Name: commonnamefocalcrop_idcommonnamefocalcrop_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE commonnamefocalcrop_idcommonnamefocalcrop_seq OWNED BY commonnamefocalcrop.idcommonnamefocalcrop;


--
-- Name: commonnames_idcommonnames_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE commonnames_idcommonnames_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.commonnames_idcommonnames_seq OWNER TO postgres;

--
-- Name: commonnames_idcommonnames_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE commonnames_idcommonnames_seq OWNED BY commonname.idcommonname;


--
-- Name: continent; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE continent (
    idcontinent integer NOT NULL,
    continent text NOT NULL
);


ALTER TABLE public.continent OWNER TO postgres;

--
-- Name: continents_idcontinent_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE continents_idcontinent_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.continents_idcontinent_seq OWNER TO postgres;

--
-- Name: continents_idcontinent_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE continents_idcontinent_seq OWNED BY continent.idcontinent;


--
-- Name: contributor; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE contributor (
    idcontributor integer NOT NULL,
    contributor character varying(100)
);


ALTER TABLE public.contributor OWNER TO postgres;

--
-- Name: contributors_idcontributors_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE contributors_idcontributors_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.contributors_idcontributors_seq OWNER TO postgres;

--
-- Name: contributors_idcontributors_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE contributors_idcontributors_seq OWNED BY contributor.idcontributor;


--
-- Name: county; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE county (
    idcounty integer NOT NULL,
    county text NOT NULL
);


ALTER TABLE public.county OWNER TO postgres;

--
-- Name: counties_idcounty_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE counties_idcounty_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.counties_idcounty_seq OWNER TO postgres;

--
-- Name: counties_idcounty_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE counties_idcounty_seq OWNED BY county.idcounty;


--
-- Name: country; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE country (
    idcountry integer NOT NULL,
    country text NOT NULL,
    googlevalidation boolean DEFAULT false,
    geonamesvalidation boolean DEFAULT false,
    biogeomancervalidation boolean DEFAULT false
);


ALTER TABLE public.country OWNER TO postgres;

--
-- Name: countries_idcountry_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE countries_idcountry_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.countries_idcountry_seq OWNER TO postgres;

--
-- Name: countries_idcountry_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE countries_idcountry_seq OWNED BY country.idcountry;


--
-- Name: creator; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE creator (
    idcreator integer NOT NULL,
    creator character varying(800)
);


ALTER TABLE public.creator OWNER TO postgres;

--
-- Name: creators_idcreators_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE creators_idcreators_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.creators_idcreators_seq OWNER TO postgres;

--
-- Name: creators_idcreators_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE creators_idcreators_seq OWNED BY creator.idcreator;


--
-- Name: cultivar; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cultivar (
    idcultivar integer NOT NULL,
    cultivar character varying
);


ALTER TABLE public.cultivar OWNER TO postgres;

--
-- Name: cultivar_idcultivar_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cultivar_idcultivar_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.cultivar_idcultivar_seq OWNER TO postgres;

--
-- Name: cultivar_idcultivar_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cultivar_idcultivar_seq OWNED BY cultivar.idcultivar;


--
-- Name: culture; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE culture (
    idculture integer NOT NULL,
    culture character varying
);


ALTER TABLE public.culture OWNER TO postgres;

--
-- Name: culture_idculture_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE culture_idculture_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.culture_idculture_seq OWNER TO postgres;

--
-- Name: culture_idculture_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE culture_idculture_seq OWNED BY culture.idculture;


--
-- Name: curatorialassociatedsequence; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE curatorialassociatedsequence (
    idassociatedsequence integer NOT NULL,
    idcuratorialelement integer NOT NULL
);


ALTER TABLE public.curatorialassociatedsequence OWNER TO postgres;

--
-- Name: curatorialelement; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE curatorialelement (
    idcuratorialelement integer NOT NULL,
    fieldnumber text,
    fieldnote text,
    verbatimeventdate text,
    verbatimelevation text,
    verbatimdepth text,
    individualcount integer,
    iddisposition integer,
    dateidentified date
);


ALTER TABLE public.curatorialelement OWNER TO postgres;

--
-- Name: curatorialelements_idcuratorialelements_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE curatorialelements_idcuratorialelements_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.curatorialelements_idcuratorialelements_seq OWNER TO postgres;

--
-- Name: curatorialelements_idcuratorialelements_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE curatorialelements_idcuratorialelements_seq OWNED BY curatorialelement.idcuratorialelement;


--
-- Name: curatorialidentifiedby; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE curatorialidentifiedby (
    idcuratorialelement integer NOT NULL,
    ididentifiedby integer NOT NULL
);


ALTER TABLE public.curatorialidentifiedby OWNER TO postgres;

--
-- Name: curatorialpreparation; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE curatorialpreparation (
    idpreparation integer NOT NULL,
    idcuratorialelement integer NOT NULL
);


ALTER TABLE public.curatorialpreparation OWNER TO postgres;

--
-- Name: curatorialrecordedby; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE curatorialrecordedby (
    idrecordedby integer NOT NULL,
    idcuratorialelement integer NOT NULL
);


ALTER TABLE public.curatorialrecordedby OWNER TO postgres;

--
-- Name: curatorialtypestatus; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE curatorialtypestatus (
    idcuratorialelement integer NOT NULL,
    idtypestatus integer NOT NULL
);


ALTER TABLE public.curatorialtypestatus OWNER TO postgres;

--
-- Name: dataset; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE dataset (
    iddataset integer NOT NULL,
    dataset character varying(100)
);


ALTER TABLE public.dataset OWNER TO postgres;

--
-- Name: dataset_iddataset_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE dataset_iddataset_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.dataset_iddataset_seq OWNER TO postgres;

--
-- Name: dataset_iddataset_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE dataset_iddataset_seq OWNED BY dataset.iddataset;


--
-- Name: datasheet_table; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE datasheet_table (
    creator character varying(800),
    language character varying(800),
    publisher character varying(800),
    title character varying(800),
    subject character varying(800),
    bibliographiccitation text,
    subtypereference character varying(800),
    isbnissn character varying,
    publicationyear integer,
    source character varying(800)
);


ALTER TABLE public.datasheet_table OWNER TO postgres;

--
-- Name: deficit; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE deficit (
    iddeficit integer NOT NULL,
    idcommonnamefocalcrop integer,
    idlocalityelement integer,
    idgeospatialelement integer,
    idtypeholding integer,
    year integer,
    dimension character varying,
    fieldsize character varying,
    idtopograficalsituation integer,
    idsoiltype integer,
    idsoilpreparation integer,
    hedgesurroundingfield boolean,
    idmainplantspeciesinhedge integer,
    distanceofnaturalhabitat character varying,
    idscientificname integer,
    idproductionvariety integer,
    idoriginseeds integer,
    plantingdate date,
    idtypeplanting integer,
    plantdensity character varying,
    idtypestand integer,
    ratiopollenizertree character varying,
    distancebetweenrows numeric,
    distanceamongplantswithinrows numeric,
    idfocuscrop integer,
    size character varying,
    idtreatment integer,
    date date,
    idobserver integer,
    recordingnumber integer,
    timeatstart time without time zone,
    period character varying,
    idweathercondition integer,
    plotnumber integer,
    numberflowersobserved integer,
    apismellifera integer,
    bumblebees integer,
    otherbees integer,
    other integer,
    remark character varying,
    fieldnumber character varying,
    varietypollenizer character varying,
    isrestricted boolean,
    idgroup integer
);


ALTER TABLE public.deficit OWNER TO postgres;

--
-- Name: deficit_iddeficit_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE deficit_iddeficit_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.deficit_iddeficit_seq OWNER TO postgres;

--
-- Name: deficit_iddeficit_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE deficit_iddeficit_seq OWNED BY deficit.iddeficit;


--
-- Name: denomination; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE denomination (
    iddenomination integer NOT NULL,
    denomination character varying
);


ALTER TABLE public.denomination OWNER TO postgres;

--
-- Name: denomination_iddenomination_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE denomination_iddenomination_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.denomination_iddenomination_seq OWNER TO postgres;

--
-- Name: denomination_iddenomination_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE denomination_iddenomination_seq OWNED BY denomination.iddenomination;


--
-- Name: digitizer; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE digitizer (
    iddigitizer integer NOT NULL,
    digitizer character varying
);


ALTER TABLE public.digitizer OWNER TO postgres;

--
-- Name: digitizer_iddigitizer_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE digitizer_iddigitizer_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.digitizer_iddigitizer_seq OWNER TO postgres;

--
-- Name: digitizer_iddigitizer_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE digitizer_iddigitizer_seq OWNED BY digitizer.iddigitizer;


--
-- Name: disease; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE disease (
    iddisease integer NOT NULL,
    disease character varying(255)
);


ALTER TABLE public.disease OWNER TO postgres;

--
-- Name: diseases_iddiseases_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diseases_iddiseases_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.diseases_iddiseases_seq OWNER TO postgres;

--
-- Name: diseases_iddiseases_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diseases_iddiseases_seq OWNED BY disease.iddisease;


--
-- Name: dispersal; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE dispersal (
    iddispersal integer NOT NULL,
    dispersal character varying(255)
);


ALTER TABLE public.dispersal OWNER TO postgres;

--
-- Name: dispersals_iddispersal_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE dispersals_iddispersal_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.dispersals_iddispersal_seq OWNER TO postgres;

--
-- Name: dispersals_iddispersal_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE dispersals_iddispersal_seq OWNED BY dispersal.iddispersal;


--
-- Name: disposition; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE disposition (
    iddisposition integer NOT NULL,
    disposition character varying(60) NOT NULL
);


ALTER TABLE public.disposition OWNER TO postgres;

--
-- Name: disposition_iddisposition_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE disposition_iddisposition_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.disposition_iddisposition_seq OWNER TO postgres;

--
-- Name: disposition_iddisposition_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE disposition_iddisposition_seq OWNED BY disposition.iddisposition;


--
-- Name: dynamicproperties_iddynamicproperties_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE dynamicproperties_iddynamicproperties_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.dynamicproperties_iddynamicproperties_seq OWNER TO postgres;

--
-- Name: dynamicproperties_iddynamicproperties_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE dynamicproperties_iddynamicproperties_seq OWNED BY dynamicproperty.iddynamicproperty;


--
-- Name: establishmentmean; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE establishmentmean (
    idestablishmentmean integer NOT NULL,
    establishmentmean character varying(36) NOT NULL
);


ALTER TABLE public.establishmentmean OWNER TO postgres;

--
-- Name: establishmentmeanss_idestablishmentmeans_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE establishmentmeanss_idestablishmentmeans_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.establishmentmeanss_idestablishmentmeans_seq OWNER TO postgres;

--
-- Name: establishmentmeanss_idestablishmentmeans_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE establishmentmeanss_idestablishmentmeans_seq OWNED BY establishmentmean.idestablishmentmean;


--
-- Name: eventelement; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE eventelement (
    ideventelement integer NOT NULL,
    idsamplingprotocol integer,
    samplingeffort text,
    eventdate date,
    verbatimeventdate text,
    idhabitat integer,
    fieldnumber text,
    fieldnote text,
    eventremark text,
    eventtime time without time zone
);


ALTER TABLE public.eventelement OWNER TO postgres;

--
-- Name: eventelements_ideventelements_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE eventelements_ideventelements_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.eventelements_ideventelements_seq OWNER TO postgres;

--
-- Name: eventelements_ideventelements_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE eventelements_ideventelements_seq OWNED BY eventelement.ideventelement;


--
-- Name: family; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE family (
    idfamily integer NOT NULL,
    family text NOT NULL,
    colvalidation boolean DEFAULT false
);


ALTER TABLE public.family OWNER TO postgres;

--
-- Name: families_idfamily_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE families_idfamily_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.families_idfamily_seq OWNER TO postgres;

--
-- Name: families_idfamily_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE families_idfamily_seq OWNED BY family.idfamily;


--
-- Name: file; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE file (
    idfile integer NOT NULL,
    filename character varying(255),
    path character varying(1000),
    filesystemname character(255),
    size integer DEFAULT 0,
    extension character(5),
    aux integer
);


ALTER TABLE public.file OWNER TO postgres;

--
-- Name: fileformat; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE fileformat (
    idfileformat integer NOT NULL,
    fileformat character varying(10) NOT NULL
);


ALTER TABLE public.fileformat OWNER TO postgres;

--
-- Name: fileformats_idfileformats_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE fileformats_idfileformats_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.fileformats_idfileformats_seq OWNER TO postgres;

--
-- Name: fileformats_idfileformats_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE fileformats_idfileformats_seq OWNED BY fileformat.idfileformat;


--
-- Name: files_idfile_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE files_idfile_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.files_idfile_seq OWNER TO postgres;

--
-- Name: files_idfile_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE files_idfile_seq OWNED BY file.idfile;


--
-- Name: focuscrop; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE focuscrop (
    idfocuscrop integer NOT NULL,
    focuscrop character varying
);


ALTER TABLE public.focuscrop OWNER TO postgres;

--
-- Name: focuscrop_idfocuscrop_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE focuscrop_idfocuscrop_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.focuscrop_idfocuscrop_seq OWNER TO postgres;

--
-- Name: focuscrop_idfocuscrop_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE focuscrop_idfocuscrop_seq OWNED BY focuscrop.idfocuscrop;


--
-- Name: formatmedia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE formatmedia (
    idformatmedia integer NOT NULL,
    formatmedia character varying(16)
);


ALTER TABLE public.formatmedia OWNER TO postgres;

--
-- Name: formatmedia_idformatmedia_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE formatmedia_idformatmedia_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.formatmedia_idformatmedia_seq OWNER TO postgres;

--
-- Name: formatmedia_idformatmedia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE formatmedia_idformatmedia_seq OWNED BY formatmedia.idformatmedia;


--
-- Name: genus; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE genus (
    idgenus integer NOT NULL,
    genus text NOT NULL,
    colvalidation boolean DEFAULT false
);


ALTER TABLE public.genus OWNER TO postgres;

--
-- Name: genus_idgenus_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE genus_idgenus_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.genus_idgenus_seq OWNER TO postgres;

--
-- Name: genus_idgenus_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE genus_idgenus_seq OWNED BY genus.idgenus;


SET default_with_oids = true;

--
-- Name: geometry_columns; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE geometry_columns (
    f_table_catalog character varying(256) NOT NULL,
    f_table_schema character varying(256) NOT NULL,
    f_table_name character varying(256) NOT NULL,
    f_geometry_column character varying(256) NOT NULL,
    coord_dimension integer NOT NULL,
    srid integer NOT NULL,
    type character varying(30) NOT NULL
);


ALTER TABLE public.geometry_columns OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: georeferencedby; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE georeferencedby (
    idgeoreferencedby integer NOT NULL,
    georeferencedby character varying(256)
);


ALTER TABLE public.georeferencedby OWNER TO postgres;

--
-- Name: georeferedby_idgeoreferdby_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE georeferedby_idgeoreferdby_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.georeferedby_idgeoreferdby_seq OWNER TO postgres;

--
-- Name: georeferedby_idgeoreferdby_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE georeferedby_idgeoreferdby_seq OWNED BY georeferencedby.idgeoreferencedby;


--
-- Name: georeferencesource; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE georeferencesource (
    idgeoreferencesource integer NOT NULL,
    georeferencesource text
);


ALTER TABLE public.georeferencesource OWNER TO postgres;

--
-- Name: georeferencesources_idgeoreferencesources_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE georeferencesources_idgeoreferencesources_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.georeferencesources_idgeoreferencesources_seq OWNER TO postgres;

--
-- Name: georeferencesources_idgeoreferencesources_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE georeferencesources_idgeoreferencesources_seq OWNED BY georeferencesource.idgeoreferencesource;


--
-- Name: georeferenceverificationstatus; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE georeferenceverificationstatus (
    idgeoreferenceverificationstatus integer NOT NULL,
    georeferenceverificationstatus character varying(64)
);


ALTER TABLE public.georeferenceverificationstatus OWNER TO postgres;

--
-- Name: georeferenceverificationstatu_idgeoreferenceverificationsta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE georeferenceverificationstatu_idgeoreferenceverificationsta_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.georeferenceverificationstatu_idgeoreferenceverificationsta_seq OWNER TO postgres;

--
-- Name: georeferenceverificationstatu_idgeoreferenceverificationsta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE georeferenceverificationstatu_idgeoreferenceverificationsta_seq OWNED BY georeferenceverificationstatus.idgeoreferenceverificationstatus;


--
-- Name: geospatialelement; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE geospatialelement (
    idgeospatialelement integer NOT NULL,
    decimallongitude numeric,
    decimallatitude numeric,
    coordinateuncertaintyinmeters double precision,
    georeferenceremark text,
    geodeticdatum text,
    pointradiusspatialfit text,
    verbatimcoordinate text,
    verbatimlatitude text,
    verbatimlongitude text,
    verbatimcoordinatesystem text,
    georeferenceprotocol text,
    footprintwkt text,
    footprintspatialfit text,
    idgeoreferenceverificationstatus integer,
    referencepoints text
);


ALTER TABLE public.geospatialelement OWNER TO postgres;

--
-- Name: geospatialelements_idgeospatialelements_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE geospatialelements_idgeospatialelements_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.geospatialelements_idgeospatialelements_seq OWNER TO postgres;

--
-- Name: geospatialelements_idgeospatialelements_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE geospatialelements_idgeospatialelements_seq OWNED BY geospatialelement.idgeospatialelement;


--
-- Name: geospatialgeoreferencesource; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE geospatialgeoreferencesource (
    idgeoreferencesource integer NOT NULL,
    idgeospatialelement integer NOT NULL
);


ALTER TABLE public.geospatialgeoreferencesource OWNER TO postgres;

--
-- Name: groupattributes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE groupattributes (
    "idGroup" integer NOT NULL,
    "idAttribute" integer NOT NULL
);


ALTER TABLE public.groupattributes OWNER TO postgres;

--
-- Name: grouppages; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grouppages (
    "idGroup" integer NOT NULL,
    "idPage" integer NOT NULL
);


ALTER TABLE public.grouppages OWNER TO postgres;

--
-- Name: groups; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE groups (
    "idGroup" integer NOT NULL,
    "group" text NOT NULL,
    modified date
);


ALTER TABLE public.groups OWNER TO postgres;

--
-- Name: groups_idGroup_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "groups_idGroup_seq"
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."groups_idGroup_seq" OWNER TO postgres;

--
-- Name: groups_idGroup_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "groups_idGroup_seq" OWNED BY groups."idGroup";


--
-- Name: habitat; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE habitat (
    idhabitat integer NOT NULL,
    habitat character varying(1500)
);


ALTER TABLE public.habitat OWNER TO postgres;

--
-- Name: habitats_idhabitat_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE habitats_idhabitat_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.habitats_idhabitat_seq OWNER TO postgres;

--
-- Name: habitats_idhabitat_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE habitats_idhabitat_seq OWNED BY habitat.idhabitat;


--
-- Name: identificationelement; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE identificationelement (
    ididentificationelement integer NOT NULL,
    ididentificationqualifier integer,
    dateidentified date,
    identificationremark text
);


ALTER TABLE public.identificationelement OWNER TO postgres;

--
-- Name: identificationelements_ididentificationelements_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE identificationelements_ididentificationelements_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.identificationelements_ididentificationelements_seq OWNER TO postgres;

--
-- Name: identificationelements_ididentificationelements_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE identificationelements_ididentificationelements_seq OWNED BY identificationelement.ididentificationelement;


--
-- Name: identificationidentifiedby; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE identificationidentifiedby (
    ididentifiedby integer NOT NULL,
    ididentificationelement integer NOT NULL
);


ALTER TABLE public.identificationidentifiedby OWNER TO postgres;

--
-- Name: identificationkey; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE identificationkey (
    idspecies integer NOT NULL,
    idreferenceelement integer NOT NULL
);


ALTER TABLE public.identificationkey OWNER TO postgres;

--
-- Name: identificationqualifier; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE identificationqualifier (
    ididentificationqualifier integer NOT NULL,
    identificationqualifier text NOT NULL
);


ALTER TABLE public.identificationqualifier OWNER TO postgres;

--
-- Name: identificationqualifiers_ididentificationqualifier_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE identificationqualifiers_ididentificationqualifier_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.identificationqualifiers_ididentificationqualifier_seq OWNER TO postgres;

--
-- Name: identificationqualifiers_ididentificationqualifier_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE identificationqualifiers_ididentificationqualifier_seq OWNED BY identificationqualifier.ididentificationqualifier;


--
-- Name: identificationtypestatus; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE identificationtypestatus (
    ididentificationelement integer NOT NULL,
    idtypestatus integer NOT NULL
);


ALTER TABLE public.identificationtypestatus OWNER TO postgres;

--
-- Name: identifiedby; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE identifiedby (
    ididentifiedby integer NOT NULL,
    identifiedby text
);


ALTER TABLE public.identifiedby OWNER TO postgres;

--
-- Name: identifiedby_ididentifiedby_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE identifiedby_ididentifiedby_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.identifiedby_ididentifiedby_seq OWNER TO postgres;

--
-- Name: identifiedby_ididentifiedby_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE identifiedby_ididentifiedby_seq OWNED BY identifiedby.ididentifiedby;


--
-- Name: individual; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE individual (
    idindividual integer NOT NULL,
    individual character varying(30) NOT NULL
);


ALTER TABLE public.individual OWNER TO postgres;

--
-- Name: individual_idindividual_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE individual_idindividual_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.individual_idindividual_seq OWNER TO postgres;

--
-- Name: individual_idindividual_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE individual_idindividual_seq OWNED BY individual.idindividual;


--
-- Name: infraspecificepithet; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE infraspecificepithet (
    idinfraspecificepithet integer NOT NULL,
    infraspecificepithet text NOT NULL,
    colvalidation boolean DEFAULT false
);


ALTER TABLE public.infraspecificepithet OWNER TO postgres;

--
-- Name: infraspecificepithets_idinfraspecificepithet_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE infraspecificepithets_idinfraspecificepithet_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.infraspecificepithets_idinfraspecificepithet_seq OWNER TO postgres;

--
-- Name: infraspecificepithets_idinfraspecificepithet_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE infraspecificepithets_idinfraspecificepithet_seq OWNED BY infraspecificepithet.idinfraspecificepithet;


--
-- Name: institutioncode; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE institutioncode (
    idinstitutioncode integer NOT NULL,
    institutioncode text NOT NULL
);


ALTER TABLE public.institutioncode OWNER TO postgres;

--
-- Name: institutioncodes_idinstitutioncode_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE institutioncodes_idinstitutioncode_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.institutioncodes_idinstitutioncode_seq OWNER TO postgres;

--
-- Name: institutioncodes_idinstitutioncode_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE institutioncodes_idinstitutioncode_seq OWNED BY institutioncode.idinstitutioncode;


--
-- Name: instructionalmethod; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE instructionalmethod (
    idinstructionalmethod integer NOT NULL,
    instructionalmethod character varying(100)
);


ALTER TABLE public.instructionalmethod OWNER TO postgres;

--
-- Name: instructionalmethods_idinstructionalmethods_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE instructionalmethods_idinstructionalmethods_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.instructionalmethods_idinstructionalmethods_seq OWNER TO postgres;

--
-- Name: instructionalmethods_idinstructionalmethods_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE instructionalmethods_idinstructionalmethods_seq OWNED BY instructionalmethod.idinstructionalmethod;


--
-- Name: interaction; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE interaction (
    idinteraction integer NOT NULL,
    idspecimen1 integer,
    idspecimen2 integer,
    idinteractiontype integer,
    interactionrelatedinformation text,
    modified timestamp without time zone,
    isrestricted boolean DEFAULT false,
    idgroup integer
);


ALTER TABLE public.interaction OWNER TO postgres;

--
-- Name: interactiontype; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE interactiontype (
    idinteractiontype integer NOT NULL,
    interactiontype text NOT NULL
);


ALTER TABLE public.interactiontype OWNER TO postgres;

--
-- Name: recordlevelelement; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE recordlevelelement (
    idrecordlevelelement integer NOT NULL,
    modified timestamp without time zone NOT NULL,
    idinstitutioncode integer NOT NULL,
    idcollectioncode integer NOT NULL,
    idbasisofrecord integer NOT NULL,
    informationwithheld text,
    idownerinstitution integer,
    iddataset integer,
    datageneralization text,
    globaluniqueidentifier text NOT NULL,
    idtype integer,
    idlanguage integer,
    rights text,
    rightsholder text,
    accessrights text,
    bibliographiccitation text,
    isrestricted boolean DEFAULT false,
    lending boolean DEFAULT false,
    lendingwho text,
    lendingdate date
);


ALTER TABLE public.recordlevelelement OWNER TO postgres;

--
-- Name: interaction_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW interaction_view AS
    SELECT "int".idinteraction, r1.globaluniqueidentifier AS gui1, r2.globaluniqueidentifier AS gui2, interactiontype.interactiontype, "int".interactionrelatedinformation, "int".modified, "int".idgroup FROM (((((interaction "int" LEFT JOIN specimen sp1 ON (("int".idspecimen1 = sp1.idspecimen))) LEFT JOIN recordlevelelement r1 ON ((sp1.idrecordlevelelement = r1.idrecordlevelelement))) LEFT JOIN specimen sp2 ON (("int".idspecimen2 = sp2.idspecimen))) LEFT JOIN recordlevelelement r2 ON ((sp2.idrecordlevelelement = r2.idrecordlevelelement))) LEFT JOIN interactiontype ON (("int".idinteractiontype = interactiontype.idinteractiontype)));


ALTER TABLE public.interaction_view OWNER TO postgres;

--
-- Name: interactionelements_idinteractionelements_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE interactionelements_idinteractionelements_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.interactionelements_idinteractionelements_seq OWNER TO postgres;

--
-- Name: interactionelements_idinteractionelements_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE interactionelements_idinteractionelements_seq OWNED BY interaction.idinteraction;


--
-- Name: interactiontypes_idinteractiontype_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE interactiontypes_idinteractiontype_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.interactiontypes_idinteractiontype_seq OWNER TO postgres;

--
-- Name: interactiontypes_idinteractiontype_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE interactiontypes_idinteractiontype_seq OWNED BY interactiontype.idinteractiontype;


--
-- Name: island; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE island (
    idisland integer NOT NULL,
    island text NOT NULL
);


ALTER TABLE public.island OWNER TO postgres;

--
-- Name: islandgroup; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE islandgroup (
    idislandgroup integer NOT NULL,
    islandgroup text NOT NULL
);


ALTER TABLE public.islandgroup OWNER TO postgres;

--
-- Name: islandgroups_idislandgroup_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE islandgroups_idislandgroup_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.islandgroups_idislandgroup_seq OWNER TO postgres;

--
-- Name: islandgroups_idislandgroup_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE islandgroups_idislandgroup_seq OWNED BY islandgroup.idislandgroup;


--
-- Name: islands_idisland_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE islands_idisland_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.islands_idisland_seq OWNER TO postgres;

--
-- Name: islands_idisland_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE islands_idisland_seq OWNED BY island.idisland;


--
-- Name: keyword; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE keyword (
    idkeyword integer NOT NULL,
    keyword character varying
);


ALTER TABLE public.keyword OWNER TO postgres;

--
-- Name: keyword_idkeyword_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE keyword_idkeyword_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.keyword_idkeyword_seq OWNER TO postgres;

--
-- Name: keyword_idkeyword_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE keyword_idkeyword_seq OWNED BY keyword.idkeyword;


--
-- Name: kingdom_idkingdom_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE kingdom_idkingdom_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.kingdom_idkingdom_seq OWNER TO postgres;

--
-- Name: kingdom_idkingdom_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE kingdom_idkingdom_seq OWNED BY kingdom.idkingdom;


--
-- Name: language; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE language (
    idlanguage integer NOT NULL,
    language character varying(100),
    codelanguage character(2)
);


ALTER TABLE public.language OWNER TO postgres;

--
-- Name: languages_idlanguages_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE languages_idlanguages_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.languages_idlanguages_seq OWNER TO postgres;

--
-- Name: languages_idlanguages_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE languages_idlanguages_seq OWNED BY language.idlanguage;


--
-- Name: license; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE license (
    idlicense integer NOT NULL,
    license text
);


ALTER TABLE public.license OWNER TO postgres;

--
-- Name: licenses_idlicenses_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE licenses_idlicenses_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.licenses_idlicenses_seq OWNER TO postgres;

--
-- Name: licenses_idlicenses_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE licenses_idlicenses_seq OWNED BY license.idlicense;


--
-- Name: lifecycle; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE lifecycle (
    idlifecycle integer NOT NULL,
    lifecycle character varying(50)
);


ALTER TABLE public.lifecycle OWNER TO postgres;

--
-- Name: lifecycles_idlifecycles_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE lifecycles_idlifecycles_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.lifecycles_idlifecycles_seq OWNER TO postgres;

--
-- Name: lifecycles_idlifecycles_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE lifecycles_idlifecycles_seq OWNED BY lifecycle.idlifecycle;


--
-- Name: lifeexpectancy; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE lifeexpectancy (
    idlifeexpectancy integer NOT NULL,
    lifeexpectancy character varying(255)
);


ALTER TABLE public.lifeexpectancy OWNER TO postgres;

--
-- Name: lifeexpectancies_idlifeexpectancies_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE lifeexpectancies_idlifeexpectancies_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.lifeexpectancies_idlifeexpectancies_seq OWNER TO postgres;

--
-- Name: lifeexpectancies_idlifeexpectancies_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE lifeexpectancies_idlifeexpectancies_seq OWNED BY lifeexpectancy.idlifeexpectancy;


--
-- Name: lifestage; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE lifestage (
    idlifestage integer NOT NULL,
    lifestage text NOT NULL
);


ALTER TABLE public.lifestage OWNER TO postgres;

--
-- Name: lifestages_idlifestage_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE lifestages_idlifestage_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.lifestages_idlifestage_seq OWNER TO postgres;

--
-- Name: lifestages_idlifestage_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE lifestages_idlifestage_seq OWNED BY lifestage.idlifestage;


--
-- Name: locality; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE locality (
    idlocality integer NOT NULL,
    locality text NOT NULL
);


ALTER TABLE public.locality OWNER TO postgres;

--
-- Name: localities_idlocality_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE localities_idlocality_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.localities_idlocality_seq OWNER TO postgres;

--
-- Name: localities_idlocality_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE localities_idlocality_seq OWNED BY locality.idlocality;


--
-- Name: localityelement; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE localityelement (
    idlocalityelement integer NOT NULL,
    idlocality integer,
    idwaterbody integer,
    idislandgroup integer,
    idisland integer,
    idcounty integer,
    idstateprovince integer,
    idcountry integer,
    idcontinent integer,
    minimumelevationinmeters character varying(20),
    maximumelevationinmeters character varying(20),
    minimumdepthinmeters character varying(20),
    maximumdepthinmeters character varying(20),
    verbatimlocality text,
    minimumdistanceabovesurfaceinmeters real,
    maximumdistanceabovesurfaceinmeters real,
    locationaccordingto text,
    locationremark text,
    verbatimdepth text,
    idmunicipality integer,
    idhabitat integer,
    verbatimelevation text,
    verbatimsrs text,
    coordinateprecision character varying(256),
    footprintsrs character varying(256),
    highergeograph text,
    idgeoreferenceverificationstatus integer,
    idsite_ integer,
    googlevalidation boolean DEFAULT false,
    geonamesvalidation boolean DEFAULT false,
    biogeomancervalidation boolean DEFAULT false,
    geolocatevalidation boolean DEFAULT false
);


ALTER TABLE public.localityelement OWNER TO postgres;

--
-- Name: localityelements_idlocalityelements_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE localityelements_idlocalityelements_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.localityelements_idlocalityelements_seq OWNER TO postgres;

--
-- Name: localityelements_idlocalityelements_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE localityelements_idlocalityelements_seq OWNED BY localityelement.idlocalityelement;


--
-- Name: localitygeoreferencedby; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE localitygeoreferencedby (
    idgeoreferencedby integer NOT NULL,
    idlocalityelement integer NOT NULL
);


ALTER TABLE public.localitygeoreferencedby OWNER TO postgres;

--
-- Name: localitygeoreferencesource; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE localitygeoreferencesource (
    idgeoreferencesource integer NOT NULL,
    idlocalityelement integer NOT NULL
);


ALTER TABLE public.localitygeoreferencesource OWNER TO postgres;

--
-- Name: log; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE log (
    idlog integer NOT NULL,
    iduser integer,
    date date DEFAULT ('now'::text)::date,
    "time" time without time zone DEFAULT ('now'::text)::time with time zone,
    type character varying DEFAULT 'create'::character varying,
    module character varying DEFAULT 'specimen'::character varying,
    source character varying DEFAULT 'form'::character varying,
    id integer,
    transaction character varying,
    idgroup integer
);


ALTER TABLE public.log OWNER TO postgres;

--
-- Name: COLUMN log.type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN log.type IS 'create, update, delete';


--
-- Name: COLUMN log.module; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN log.module IS 'specimen, interaction, specie, deficit, media, reference or monitoring';


--
-- Name: COLUMN log.source; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN log.source IS 'form or xls';


--
-- Name: COLUMN log.id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN log.id IS 'Id of record.';


--
-- Name: log_dq; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE log_dq (
    id integer NOT NULL,
    id_specimen integer NOT NULL,
    id_type_log integer NOT NULL,
    id_user integer NOT NULL,
    date_update date NOT NULL,
    time_update time with time zone,
    undo_log integer,
    id_log_dq_deleted_items integer NOT NULL,
    type_execution integer,
    id_process integer
);


ALTER TABLE public.log_dq OWNER TO postgres;

--
-- Name: log_dq_deleted_items; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE log_dq_deleted_items (
    id integer NOT NULL,
    item_type character varying(200) NOT NULL,
    item_name character varying(200) NOT NULL,
    id_current_taxon integer NOT NULL
);


ALTER TABLE public.log_dq_deleted_items OWNER TO postgres;

--
-- Name: log_dq_deleted_items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE log_dq_deleted_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.log_dq_deleted_items_id_seq OWNER TO postgres;

--
-- Name: log_dq_deleted_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE log_dq_deleted_items_id_seq OWNED BY log_dq_deleted_items.id;


--
-- Name: log_dq_fields; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE log_dq_fields (
    id integer NOT NULL,
    id_log_dq integer NOT NULL,
    field_name character varying(200) NOT NULL,
    field_value character varying(200)
);


ALTER TABLE public.log_dq_fields OWNER TO postgres;

--
-- Name: log_dq_fields_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE log_dq_fields_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.log_dq_fields_id_seq OWNER TO postgres;

--
-- Name: log_dq_fields_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE log_dq_fields_id_seq OWNED BY log_dq_fields.id;


--
-- Name: log_dq_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE log_dq_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.log_dq_id_seq OWNER TO postgres;

--
-- Name: log_dq_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE log_dq_id_seq OWNED BY log_dq.id;


--
-- Name: log_idlog_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE log_idlog_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.log_idlog_seq OWNER TO postgres;

--
-- Name: log_idlog_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE log_idlog_seq OWNED BY log.idlog;


--
-- Name: mainplantspeciesinhedge; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mainplantspeciesinhedge (
    idmainplantspeciesinhedge integer NOT NULL,
    mainplantspeciesinhedge character varying
);


ALTER TABLE public.mainplantspeciesinhedge OWNER TO postgres;

--
-- Name: mainplantspeciesinhedge_idmainplantspeciesinhedge_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE mainplantspeciesinhedge_idmainplantspeciesinhedge_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.mainplantspeciesinhedge_idmainplantspeciesinhedge_seq OWNER TO postgres;

--
-- Name: mainplantspeciesinhedge_idmainplantspeciesinhedge_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE mainplantspeciesinhedge_idmainplantspeciesinhedge_seq OWNED BY mainplantspeciesinhedge.idmainplantspeciesinhedge;


--
-- Name: media; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE media (
    idmedia integer NOT NULL,
    caption character varying,
    description text,
    publishedsource character varying,
    attributionlinkurl character varying,
    attributionlogourl character varying,
    attributionstatement character varying,
    copyrightstatement character varying,
    copyrightowner character varying,
    dateavailable date,
    modified timestamp without time zone,
    comment text,
    title character varying,
    datedigitized date,
    timedigitized time without time zone,
    accesspoint character varying,
    accessurl character varying,
    extent character varying,
    idlanguage integer,
    idmetadataprovider integer,
    idsubtype integer,
    idcapturedevice integer,
    idtypemedia integer,
    idsubcategorymedia integer,
    idcategorymedia integer,
    idfile integer,
    isrestricted boolean,
    idprovider integer,
    idformatmedia integer,
    idfileformat integer,
    idgroup integer,
    aux integer
);


ALTER TABLE public.media OWNER TO postgres;

--
-- Name: media_idmedia_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE media_idmedia_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.media_idmedia_seq OWNER TO postgres;

--
-- Name: media_idmedia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE media_idmedia_seq OWNED BY media.idmedia;


--
-- Name: mediacreator; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mediacreator (
    idcreator integer NOT NULL,
    idmedia integer NOT NULL
);


ALTER TABLE public.mediacreator OWNER TO postgres;

--
-- Name: mediasubjectcategory; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mediasubjectcategory (
    idsubjectcategory integer NOT NULL,
    idmedia integer NOT NULL
);


ALTER TABLE public.mediasubjectcategory OWNER TO postgres;

--
-- Name: mediatag; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mediatag (
    idtag integer NOT NULL,
    idmedia integer NOT NULL
);


ALTER TABLE public.mediatag OWNER TO postgres;

--
-- Name: metadataprovider; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE metadataprovider (
    idmetadataprovider integer NOT NULL,
    metadataprovider character varying(80)
);


ALTER TABLE public.metadataprovider OWNER TO postgres;

--
-- Name: metadataprovider_idmetadataprovider_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE metadataprovider_idmetadataprovider_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.metadataprovider_idmetadataprovider_seq OWNER TO postgres;

--
-- Name: metadataprovider_idmetadataprovider_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE metadataprovider_idmetadataprovider_seq OWNED BY metadataprovider.idmetadataprovider;


--
-- Name: migration; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE migration (
    idmigration integer NOT NULL,
    migration character varying(255)
);


ALTER TABLE public.migration OWNER TO postgres;

--
-- Name: migrations_idmigration_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE migrations_idmigration_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.migrations_idmigration_seq OWNER TO postgres;

--
-- Name: migrations_idmigration_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE migrations_idmigration_seq OWNED BY migration.idmigration;


--
-- Name: monitoring; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE monitoring (
    iddenomination integer,
    idtechnicalcollection integer,
    iddigitizer integer,
    idculture integer,
    idcultivar integer,
    idpredominantbiome integer,
    installationdate date,
    installationtime time without time zone,
    collectdate date,
    collecttime time without time zone,
    idsurroundingsculture integer,
    plotnumber integer,
    amostralnumber integer,
    idcolorpantrap integer,
    idsupporttype integer,
    floorheight numeric,
    weight numeric,
    idcollector integer,
    width numeric,
    length numeric,
    height numeric,
    idmonitoring integer NOT NULL,
    idgeospatialelement integer,
    idlocalityelement integer,
    idtaxonomicelement integer,
    idrecordlevelelement integer,
    idoccurrenceelement integer,
    idgeral character varying,
    tipodesuporte character varying,
    idsurroundingsvegetation integer,
    idgroup integer
);


ALTER TABLE public.monitoring OWNER TO postgres;

--
-- Name: monitoring_idmonitoring_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE monitoring_idmonitoring_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.monitoring_idmonitoring_seq OWNER TO postgres;

--
-- Name: monitoring_idmonitoring_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE monitoring_idmonitoring_seq OWNED BY monitoring.idmonitoring;


--
-- Name: morphospecies; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE morphospecies (
    idmorphospecies integer NOT NULL,
    morphospecies character varying NOT NULL,
    idgroup integer
);


ALTER TABLE public.morphospecies OWNER TO postgres;

--
-- Name: morphospecies_idmorphospecies_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE morphospecies_idmorphospecies_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.morphospecies_idmorphospecies_seq OWNER TO postgres;

--
-- Name: morphospecies_idmorphospecies_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE morphospecies_idmorphospecies_seq OWNED BY morphospecies.idmorphospecies;


--
-- Name: municipality; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE municipality (
    idmunicipality integer NOT NULL,
    municipality character varying(256),
    googlevalidation boolean DEFAULT false,
    biogeomancervalidation boolean DEFAULT false,
    geonamesvalidation boolean DEFAULT false
);


ALTER TABLE public.municipality OWNER TO postgres;

--
-- Name: municipality_idmunicipality_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE municipality_idmunicipality_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.municipality_idmunicipality_seq OWNER TO postgres;

--
-- Name: municipality_idmunicipality_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE municipality_idmunicipality_seq OWNED BY municipality.idmunicipality;


--
-- Name: nameaccordingto; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE nameaccordingto (
    idnameaccordingto integer NOT NULL,
    nameaccordingto character varying(120)
);


ALTER TABLE public.nameaccordingto OWNER TO postgres;

--
-- Name: nameaccordingto_idnameaccordingto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE nameaccordingto_idnameaccordingto_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.nameaccordingto_idnameaccordingto_seq OWNER TO postgres;

--
-- Name: nameaccordingto_idnameaccordingto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE nameaccordingto_idnameaccordingto_seq OWNED BY nameaccordingto.idnameaccordingto;


--
-- Name: namepublishedin; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE namepublishedin (
    idnamepublishedin integer NOT NULL,
    namepublishedin character varying(120)
);


ALTER TABLE public.namepublishedin OWNER TO postgres;

--
-- Name: namepublishedin_idnamepublishedin_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE namepublishedin_idnamepublishedin_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.namepublishedin_idnamepublishedin_seq OWNER TO postgres;

--
-- Name: namepublishedin_idnamepublishedin_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE namepublishedin_idnamepublishedin_seq OWNED BY namepublishedin.idnamepublishedin;


--
-- Name: nomenclaturalcode; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE nomenclaturalcode (
    idnomenclaturalcode integer NOT NULL,
    nomenclaturalcode text NOT NULL
);


ALTER TABLE public.nomenclaturalcode OWNER TO postgres;

--
-- Name: nomenclaturalcodes_idnomenclaturalcode_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE nomenclaturalcodes_idnomenclaturalcode_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.nomenclaturalcodes_idnomenclaturalcode_seq OWNER TO postgres;

--
-- Name: nomenclaturalcodes_idnomenclaturalcode_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE nomenclaturalcodes_idnomenclaturalcode_seq OWNED BY nomenclaturalcode.idnomenclaturalcode;


--
-- Name: observer; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE observer (
    idobserver integer NOT NULL,
    observer character varying
);


ALTER TABLE public.observer OWNER TO postgres;

--
-- Name: observer_idobserver_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE observer_idobserver_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.observer_idobserver_seq OWNER TO postgres;

--
-- Name: observer_idobserver_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE observer_idobserver_seq OWNED BY observer.idobserver;


--
-- Name: occurrenceelement; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE occurrenceelement (
    idoccurrenceelement integer NOT NULL,
    catalognumber character varying(256) NOT NULL,
    occurrencedetail text,
    occurrenceremark text,
    recordnumber character varying(256),
    individualcount integer,
    occurrencestatus character varying(56),
    iddisposition integer,
    idestablishmentmean integer,
    idbehavior integer,
    idreproductivecondition integer,
    idlifestage integer,
    idsex integer,
    othercatalognumber text
);


ALTER TABLE public.occurrenceelement OWNER TO postgres;

--
-- Name: occurrence_idoccurrence_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE occurrence_idoccurrence_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.occurrence_idoccurrence_seq OWNER TO postgres;

--
-- Name: occurrence_idoccurrence_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE occurrence_idoccurrence_seq OWNED BY occurrenceelement.idoccurrenceelement;


--
-- Name: occurrenceassociatedsequence; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE occurrenceassociatedsequence (
    idoccurrenceelement integer NOT NULL,
    idassociatedsequence integer NOT NULL
);


ALTER TABLE public.occurrenceassociatedsequence OWNER TO postgres;

--
-- Name: occurrencerecordedby; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE occurrencerecordedby (
    idrecordedby integer NOT NULL,
    idoccurrenceelement integer NOT NULL
);


ALTER TABLE public.occurrencerecordedby OWNER TO postgres;

--
-- Name: recordedby; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE recordedby (
    idrecordedby integer NOT NULL,
    recordedby text
);


ALTER TABLE public.recordedby OWNER TO postgres;

--
-- Name: occurrenceelement_recordedby_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW occurrenceelement_recordedby_view AS
    SELECT r.idrecordedby, r.recordedby, o.idoccurrenceelement, s.idgroup FROM ((occurrencerecordedby o JOIN recordedby r ON ((r.idrecordedby = o.idrecordedby))) JOIN specimen s ON ((s.idoccurrenceelement = o.idoccurrenceelement)));


ALTER TABLE public.occurrenceelement_recordedby_view OWNER TO postgres;

--
-- Name: occurrencepreparation; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE occurrencepreparation (
    idoccurrenceelement integer NOT NULL,
    idpreparation integer NOT NULL
);


ALTER TABLE public.occurrencepreparation OWNER TO postgres;

--
-- Name: preparation; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE preparation (
    idpreparation integer NOT NULL,
    preparation character varying(256)
);


ALTER TABLE public.preparation OWNER TO postgres;

--
-- Name: occurrenceelementpreparationview; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW occurrenceelementpreparationview AS
    SELECT r.idpreparation, r.preparation, o.idoccurrenceelement, s.idgroup FROM ((occurrencepreparation o JOIN preparation r ON ((r.idpreparation = o.idpreparation))) JOIN specimen s ON ((s.idoccurrenceelement = o.idoccurrenceelement)));


ALTER TABLE public.occurrenceelementpreparationview OWNER TO postgres;

--
-- Name: occurrenceelementrecordedbyview; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW occurrenceelementrecordedbyview AS
    SELECT r.idrecordedby, r.recordedby, o.idoccurrenceelement, s.idgroup FROM ((occurrencerecordedby o JOIN recordedby r ON ((r.idrecordedby = o.idrecordedby))) JOIN specimen s ON ((s.idoccurrenceelement = o.idoccurrenceelement)));


ALTER TABLE public.occurrenceelementrecordedbyview OWNER TO postgres;

--
-- Name: occurrenceindividual; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE occurrenceindividual (
    idindividual integer NOT NULL,
    idoccurrenceelement integer NOT NULL
);


ALTER TABLE public.occurrenceindividual OWNER TO postgres;

--
-- Name: order; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "order" (
    idorder integer NOT NULL,
    "order" text NOT NULL,
    colvalidation boolean DEFAULT false
);


ALTER TABLE public."order" OWNER TO postgres;

--
-- Name: orders_idorder_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE orders_idorder_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.orders_idorder_seq OWNER TO postgres;

--
-- Name: orders_idorder_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE orders_idorder_seq OWNED BY "order".idorder;


--
-- Name: originalnameusage; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE originalnameusage (
    idoriginalnameusage integer NOT NULL,
    originalnameusage character varying(120)
);


ALTER TABLE public.originalnameusage OWNER TO postgres;

--
-- Name: originalnameusage_idoriginalnameusage_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE originalnameusage_idoriginalnameusage_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.originalnameusage_idoriginalnameusage_seq OWNER TO postgres;

--
-- Name: originalnameusage_idoriginalnameusage_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE originalnameusage_idoriginalnameusage_seq OWNED BY originalnameusage.idoriginalnameusage;


--
-- Name: originseeds; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE originseeds (
    idoriginseeds integer NOT NULL,
    originseeds character varying
);


ALTER TABLE public.originseeds OWNER TO postgres;

--
-- Name: originseeds_idoriginseeds_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE originseeds_idoriginseeds_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.originseeds_idoriginseeds_seq OWNER TO postgres;

--
-- Name: originseeds_idoriginseeds_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE originseeds_idoriginseeds_seq OWNED BY originseeds.idoriginseeds;


--
-- Name: ownerinstitution; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ownerinstitution (
    idownerinstitution integer NOT NULL,
    ownerinstitution text
);


ALTER TABLE public.ownerinstitution OWNER TO postgres;

--
-- Name: ownerinstitution_idownerinstitution_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ownerinstitution_idownerinstitution_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.ownerinstitution_idownerinstitution_seq OWNER TO postgres;

--
-- Name: ownerinstitution_idownerinstitution_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE ownerinstitution_idownerinstitution_seq OWNED BY ownerinstitution.idownerinstitution;


--
-- Name: page; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE page (
    idpage integer NOT NULL,
    page text NOT NULL,
    description text NOT NULL,
    url text NOT NULL,
    label text NOT NULL
);


ALTER TABLE public.page OWNER TO postgres;

--
-- Name: pages_idPage_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "pages_idPage_seq"
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."pages_idPage_seq" OWNER TO postgres;

--
-- Name: pages_idPage_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "pages_idPage_seq" OWNED BY page.idpage;


--
-- Name: parentnameusage; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE parentnameusage (
    idparentnameusage integer NOT NULL,
    parentnameusage character varying(120)
);


ALTER TABLE public.parentnameusage OWNER TO postgres;

--
-- Name: parentnameusage_idparentnameusage_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE parentnameusage_idparentnameusage_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.parentnameusage_idparentnameusage_seq OWNER TO postgres;

--
-- Name: parentnameusage_idparentnameusage_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE parentnameusage_idparentnameusage_seq OWNED BY parentnameusage.idparentnameusage;


--
-- Name: phylum; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE phylum (
    idphylum integer NOT NULL,
    phylum text NOT NULL,
    colvalidation boolean DEFAULT false
);


ALTER TABLE public.phylum OWNER TO postgres;

--
-- Name: phylums_idphylum_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE phylums_idphylum_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.phylums_idphylum_seq OWNER TO postgres;

--
-- Name: phylums_idphylum_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE phylums_idphylum_seq OWNED BY phylum.idphylum;


--
-- Name: plantcommonname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE plantcommonname (
    idplantcommonname integer NOT NULL,
    plantcommonname character varying
);


ALTER TABLE public.plantcommonname OWNER TO postgres;

--
-- Name: plantcommonname_idplantcommonname_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE plantcommonname_idplantcommonname_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.plantcommonname_idplantcommonname_seq OWNER TO postgres;

--
-- Name: plantcommonname_idplantcommonname_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE plantcommonname_idplantcommonname_seq OWNED BY plantcommonname.idplantcommonname;


--
-- Name: plantfamily; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE plantfamily (
    idplantfamily integer NOT NULL,
    plantfamily character varying
);


ALTER TABLE public.plantfamily OWNER TO postgres;

--
-- Name: plantfamily_idplantfamily_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE plantfamily_idplantfamily_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.plantfamily_idplantfamily_seq OWNER TO postgres;

--
-- Name: plantfamily_idplantfamily_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE plantfamily_idplantfamily_seq OWNED BY plantfamily.idplantfamily;


--
-- Name: plantspecies; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE plantspecies (
    idplantspecies integer NOT NULL,
    plantspecies character varying
);


ALTER TABLE public.plantspecies OWNER TO postgres;

--
-- Name: plantspecies_idplantspecies_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE plantspecies_idplantspecies_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.plantspecies_idplantspecies_seq OWNER TO postgres;

--
-- Name: plantspecies_idplantspecies_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE plantspecies_idplantspecies_seq OWNED BY plantspecies.idplantspecies;


--
-- Name: pollinatorcommonname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pollinatorcommonname (
    idpollinatorcommonname integer NOT NULL,
    pollinatorcommonname character varying
);


ALTER TABLE public.pollinatorcommonname OWNER TO postgres;

--
-- Name: pollinatorcommonname_idpollinatorcommonname_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pollinatorcommonname_idpollinatorcommonname_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.pollinatorcommonname_idpollinatorcommonname_seq OWNER TO postgres;

--
-- Name: pollinatorcommonname_idpollinatorcommonname_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pollinatorcommonname_idpollinatorcommonname_seq OWNED BY pollinatorcommonname.idpollinatorcommonname;


--
-- Name: pollinatorfamily; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pollinatorfamily (
    idpollinatorfamily integer NOT NULL,
    pollinatorfamily character varying
);


ALTER TABLE public.pollinatorfamily OWNER TO postgres;

--
-- Name: pollinatorfamily_idpollinatorfamily_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pollinatorfamily_idpollinatorfamily_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.pollinatorfamily_idpollinatorfamily_seq OWNER TO postgres;

--
-- Name: pollinatorfamily_idpollinatorfamily_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pollinatorfamily_idpollinatorfamily_seq OWNED BY pollinatorfamily.idpollinatorfamily;


--
-- Name: pollinatorspecies; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pollinatorspecies (
    idpollinatorspecies integer NOT NULL,
    pollinatorspecies character varying
);


ALTER TABLE public.pollinatorspecies OWNER TO postgres;

--
-- Name: pollinatorspecies_idpollinatorspecies_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pollinatorspecies_idpollinatorspecies_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.pollinatorspecies_idpollinatorspecies_seq OWNER TO postgres;

--
-- Name: pollinatorspecies_idpollinatorspecies_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pollinatorspecies_idpollinatorspecies_seq OWNED BY pollinatorspecies.idpollinatorspecies;


--
-- Name: predominantbiome; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE predominantbiome (
    idpredominantbiome integer NOT NULL,
    predominantbiome character varying
);


ALTER TABLE public.predominantbiome OWNER TO postgres;

--
-- Name: predominantbiome_idpredominantbiome_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE predominantbiome_idpredominantbiome_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.predominantbiome_idpredominantbiome_seq OWNER TO postgres;

--
-- Name: predominantbiome_idpredominantbiome_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE predominantbiome_idpredominantbiome_seq OWNED BY predominantbiome.idpredominantbiome;


--
-- Name: preparations_idpreparations_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE preparations_idpreparations_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.preparations_idpreparations_seq OWNER TO postgres;

--
-- Name: preparations_idpreparations_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE preparations_idpreparations_seq OWNED BY preparation.idpreparation;


--
-- Name: previousidentification; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE previousidentification (
    ididentificationelement integer NOT NULL,
    idoccurrenceelement integer NOT NULL
);


ALTER TABLE public.previousidentification OWNER TO postgres;

--
-- Name: previousidentifications_idpreviousidentifications_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE previousidentifications_idpreviousidentifications_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.previousidentifications_idpreviousidentifications_seq OWNER TO postgres;

--
-- Name: previousidentifications_idpreviousidentifications_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE previousidentifications_idpreviousidentifications_seq OWNED BY previousidentification.ididentificationelement;


--
-- Name: process_log_dq; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE process_log_dq (
    id integer NOT NULL,
    id_last_task integer NOT NULL,
    id_user integer NOT NULL,
    date_start date NOT NULL,
    time_start time with time zone NOT NULL,
    date_finish date,
    time_finish time with time zone
);


ALTER TABLE public.process_log_dq OWNER TO postgres;

--
-- Name: process_log_dq_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE process_log_dq_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.process_log_dq_id_seq OWNER TO postgres;

--
-- Name: process_log_dq_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE process_log_dq_id_seq OWNED BY process_log_dq.id;


--
-- Name: process_specimens_execution; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE process_specimens_execution (
    id integer NOT NULL,
    id_type_dq integer,
    id_process integer,
    id_specimen integer,
    type_execution integer,
    sugestion integer
);


ALTER TABLE public.process_specimens_execution OWNER TO postgres;

--
-- Name: process_specimens_execution_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE process_specimens_execution_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.process_specimens_execution_id_seq OWNER TO postgres;

--
-- Name: process_specimens_execution_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE process_specimens_execution_id_seq OWNED BY process_specimens_execution.id;


--
-- Name: process_taxons_execution; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE process_taxons_execution (
    id integer NOT NULL,
    id_type_dq integer,
    id_process integer,
    id_taxon integer,
    id_taxon_type integer,
    type_execution integer,
    sugestion integer,
    name_taxon text
);


ALTER TABLE public.process_taxons_execution OWNER TO postgres;

--
-- Name: process_taxons_execution_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE process_taxons_execution_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.process_taxons_execution_id_seq OWNER TO postgres;

--
-- Name: process_taxons_execution_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE process_taxons_execution_id_seq OWNED BY process_taxons_execution.id;


--
-- Name: productionvariety; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE productionvariety (
    idproductionvariety integer NOT NULL,
    productionvariety character varying
);


ALTER TABLE public.productionvariety OWNER TO postgres;

--
-- Name: productionvariety_idproductionvariety_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE productionvariety_idproductionvariety_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.productionvariety_idproductionvariety_seq OWNER TO postgres;

--
-- Name: productionvariety_idproductionvariety_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE productionvariety_idproductionvariety_seq OWNED BY productionvariety.idproductionvariety;


--
-- Name: provider; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE provider (
    idprovider integer NOT NULL,
    provider character varying(80)
);


ALTER TABLE public.provider OWNER TO postgres;

--
-- Name: provider_idprovider_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE provider_idprovider_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.provider_idprovider_seq OWNER TO postgres;

--
-- Name: provider_idprovider_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE provider_idprovider_seq OWNED BY provider.idprovider;


--
-- Name: publisher; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE publisher (
    idpublisher integer NOT NULL,
    publisher character varying(100)
);


ALTER TABLE public.publisher OWNER TO postgres;

--
-- Name: publishers_idpublishers_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE publishers_idpublishers_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.publishers_idpublishers_seq OWNER TO postgres;

--
-- Name: publishers_idpublishers_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE publishers_idpublishers_seq OWNED BY publisher.idpublisher;


--
-- Name: recordedby_idrecordedby_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE recordedby_idrecordedby_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.recordedby_idrecordedby_seq OWNER TO postgres;

--
-- Name: recordedby_idrecordedby_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE recordedby_idrecordedby_seq OWNED BY collectedby.idcollectedby;


--
-- Name: recordedby_idrecordedby_seq1; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE recordedby_idrecordedby_seq1
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.recordedby_idrecordedby_seq1 OWNER TO postgres;

--
-- Name: recordedby_idrecordedby_seq1; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE recordedby_idrecordedby_seq1 OWNED BY recordedby.idrecordedby;


--
-- Name: recordlevelelements_idrecordlevelelements_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE recordlevelelements_idrecordlevelelements_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.recordlevelelements_idrecordlevelelements_seq OWNER TO postgres;

--
-- Name: recordlevelelements_idrecordlevelelements_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE recordlevelelements_idrecordlevelelements_seq OWNED BY recordlevelelement.idrecordlevelelement;


--
-- Name: referencecreator; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referencecreator (
    idcreator integer NOT NULL,
    idreferenceelement integer NOT NULL
);


ALTER TABLE public.referencecreator OWNER TO postgres;

--
-- Name: referenceelement; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referenceelement (
    idreferenceelement integer NOT NULL,
    idcreator integer,
    idlanguage integer,
    idpublisher integer,
    idtypereference integer,
    title character varying(800),
    subject character varying(800),
    observation text,
    bibliographiccitation text,
    idfileformat integer,
    modified date,
    abstract text,
    created date,
    url text,
    idfile integer,
    isrestricted boolean DEFAULT false,
    idsubtypereference integer,
    isbnissn character varying,
    publicationyear integer,
    doi character varying,
    idsource integer,
    datedigitized date,
    idgroup integer
);


ALTER TABLE public.referenceelement OWNER TO postgres;

--
-- Name: reference_creators_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW reference_creators_view AS
    SELECT c.creator, ref.idreferenceelement FROM ((referenceelement ref LEFT JOIN referencecreator rc ON ((ref.idreferenceelement = rc.idreferenceelement))) LEFT JOIN creator c ON ((rc.idcreator = c.idcreator)));


ALTER TABLE public.reference_creators_view OWNER TO postgres;

--
-- Name: source; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE source (
    idsource integer NOT NULL,
    source character varying
);


ALTER TABLE public.source OWNER TO postgres;

--
-- Name: subtypereference; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE subtypereference (
    idsubtypereference integer NOT NULL,
    subtypereference character varying(64) NOT NULL
);


ALTER TABLE public.subtypereference OWNER TO postgres;

--
-- Name: typereference; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE typereference (
    idtypereference integer NOT NULL,
    typereference character varying(100)
);


ALTER TABLE public.typereference OWNER TO postgres;

--
-- Name: reference_dc; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW reference_dc AS
    SELECT r.idreferenceelement, lang.language, publisher.publisher, typereference.typereference, fileformat.fileformat, ((file.path)::text || (file.filename)::text) AS file, subtypereference.subtypereference, source.source, r.title, r.subject, r.observation, r.bibliographiccitation, r.modified, r.abstract, r.created, r.url, r.isbnissn, r.publicationyear, r.doi, nnafiliation(r.idreferenceelement) AS afiliation, nnbiome(r.idreferenceelement) AS biome, nncreator(r.idreferenceelement) AS creator, nnkeyword(r.idreferenceelement) AS keyword, nnplantcommonname(r.idreferenceelement) AS plantcommonname, nnplantfamily(r.idreferenceelement) AS plantfamily, nnplantspecies(r.idreferenceelement) AS plantspecies, nnpollinatorcommonname(r.idreferenceelement) AS pollinatorcommonname, nnpollinatorfamily(r.idreferenceelement) AS pollinatorfamily, nnpollinatorspecies(r.idreferenceelement) AS pollinatorspecies, r.idgroup FROM (((((((referenceelement r LEFT JOIN language lang ON ((r.idlanguage = lang.idlanguage))) LEFT JOIN publisher ON ((r.idpublisher = publisher.idpublisher))) LEFT JOIN typereference ON ((r.idtypereference = typereference.idtypereference))) LEFT JOIN fileformat ON ((r.idfileformat = fileformat.idfileformat))) LEFT JOIN file ON ((r.idfile = file.idfile))) LEFT JOIN subtypereference ON ((r.idsubtypereference = subtypereference.idsubtypereference))) LEFT JOIN source ON ((r.idsource = source.idsource))) WHERE (r.isrestricted = false) ORDER BY r.title;


ALTER TABLE public.reference_dc OWNER TO postgres;

--
-- Name: referencekeyword; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referencekeyword (
    idreferenceelement integer NOT NULL,
    idkeyword integer NOT NULL
);


ALTER TABLE public.referencekeyword OWNER TO postgres;

--
-- Name: reference_keywords_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW reference_keywords_view AS
    SELECT k.keyword, ref.idreferenceelement FROM ((referenceelement ref LEFT JOIN referencekeyword rk ON ((ref.idreferenceelement = rk.idreferenceelement))) LEFT JOIN keyword k ON ((rk.idkeyword = k.idkeyword)));


ALTER TABLE public.reference_keywords_view OWNER TO postgres;

--
-- Name: reference_view; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW reference_view AS
    SELECT DISTINCT ON (ref.idreferenceelement) ref.idreferenceelement, subtypereference.subtypereference, ref.idlanguage, ref.idtypereference, ref.idsubtypereference, ref.idfileformat, ref.idfile, ref.isrestricted, ref.title, ref.subject, typereference.typereference, language.language, ref.observation, ref.url, ref.bibliographiccitation, fileformat.fileformat, file.path, file.filesystemname, file.size, file.extension, ref.idgroup, ref.doi, ref.isbnissn, ref.abstract, ref.publicationyear FROM (((((referenceelement ref LEFT JOIN typereference ON ((ref.idtypereference = typereference.idtypereference))) LEFT JOIN subtypereference ON ((ref.idsubtypereference = subtypereference.idsubtypereference))) LEFT JOIN language ON ((ref.idlanguage = language.idlanguage))) LEFT JOIN fileformat ON ((ref.idfileformat = fileformat.idfileformat))) LEFT JOIN file ON ((ref.idfile = file.idfile)));


ALTER TABLE public.reference_view OWNER TO postgres;

--
-- Name: referenceafiliation; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referenceafiliation (
    idreferenceelement integer NOT NULL,
    idafiliation integer NOT NULL
);


ALTER TABLE public.referenceafiliation OWNER TO postgres;

--
-- Name: referencebiome; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referencebiome (
    idreferenceelement integer NOT NULL,
    idbiome integer NOT NULL
);


ALTER TABLE public.referencebiome OWNER TO postgres;

--
-- Name: referenceelement_idreferenceelement_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE referenceelement_idreferenceelement_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.referenceelement_idreferenceelement_seq OWNER TO postgres;

--
-- Name: referenceelement_idreferenceelement_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE referenceelement_idreferenceelement_seq OWNED BY referenceelement.idreferenceelement;


--
-- Name: referenceplantcommonname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referenceplantcommonname (
    idreferenceelement integer NOT NULL,
    idplantcommonname integer NOT NULL
);


ALTER TABLE public.referenceplantcommonname OWNER TO postgres;

--
-- Name: referenceplantfamily; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referenceplantfamily (
    idreferenceelement integer NOT NULL,
    idplantfamily integer NOT NULL
);


ALTER TABLE public.referenceplantfamily OWNER TO postgres;

--
-- Name: referenceplantspecies; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referenceplantspecies (
    idreferenceelement integer NOT NULL,
    idplantspecies integer NOT NULL
);


ALTER TABLE public.referenceplantspecies OWNER TO postgres;

--
-- Name: referencepollinatorcommonname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referencepollinatorcommonname (
    idreferenceelement integer NOT NULL,
    idpollinatorcommonname integer NOT NULL
);


ALTER TABLE public.referencepollinatorcommonname OWNER TO postgres;

--
-- Name: referencepollinatorfamily; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referencepollinatorfamily (
    idreferenceelement integer NOT NULL,
    idpollinatorfamily integer NOT NULL
);


ALTER TABLE public.referencepollinatorfamily OWNER TO postgres;

--
-- Name: referencepollinatorspecies; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referencepollinatorspecies (
    idreferenceelement integer NOT NULL,
    idpollinatorspecies integer NOT NULL
);


ALTER TABLE public.referencepollinatorspecies OWNER TO postgres;

--
-- Name: referencesidentification; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referencesidentification (
    ididentificationelements integer NOT NULL,
    idreferenceselements integer NOT NULL
);


ALTER TABLE public.referencesidentification OWNER TO postgres;

--
-- Name: referencesspecie; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referencesspecie (
    idreferenceselements integer NOT NULL,
    idspecieselements integer NOT NULL
);


ALTER TABLE public.referencesspecie OWNER TO postgres;

--
-- Name: referencestaxonomic; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE referencestaxonomic (
    idtaxonomicelements integer NOT NULL,
    idreferenceselements integer NOT NULL
);


ALTER TABLE public.referencestaxonomic OWNER TO postgres;

--
-- Name: relatedname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE relatedname (
    idrelatedname integer NOT NULL,
    relatedname character varying
);


ALTER TABLE public.relatedname OWNER TO postgres;

--
-- Name: relatedname_idrelatedname_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE relatedname_idrelatedname_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.relatedname_idrelatedname_seq OWNER TO postgres;

--
-- Name: relatedname_idrelatedname_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE relatedname_idrelatedname_seq OWNED BY relatedname.idrelatedname;


--
-- Name: reproduction; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE reproduction (
    idreproduction integer NOT NULL,
    reproduction character varying(100)
);


ALTER TABLE public.reproduction OWNER TO postgres;

--
-- Name: reproductions_idreproduction_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE reproductions_idreproduction_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.reproductions_idreproduction_seq OWNER TO postgres;

--
-- Name: reproductions_idreproduction_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE reproductions_idreproduction_seq OWNED BY reproduction.idreproduction;


--
-- Name: reproductivecondition; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE reproductivecondition (
    idreproductivecondition integer NOT NULL,
    reproductivecondition character varying(60) NOT NULL
);


ALTER TABLE public.reproductivecondition OWNER TO postgres;

--
-- Name: reproductivecondition_idreproductivecondition_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE reproductivecondition_idreproductivecondition_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.reproductivecondition_idreproductivecondition_seq OWNER TO postgres;

--
-- Name: reproductivecondition_idreproductivecondition_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE reproductivecondition_idreproductivecondition_seq OWNED BY reproductivecondition.idreproductivecondition;


--
-- Name: samplingprotocol; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE samplingprotocol (
    idsamplingprotocol integer NOT NULL,
    samplingprotocol text NOT NULL
);


ALTER TABLE public.samplingprotocol OWNER TO postgres;

--
-- Name: samplingprotocols_idsamplingprotocol_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE samplingprotocols_idsamplingprotocol_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.samplingprotocols_idsamplingprotocol_seq OWNER TO postgres;

--
-- Name: samplingprotocols_idsamplingprotocol_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE samplingprotocols_idsamplingprotocol_seq OWNED BY samplingprotocol.idsamplingprotocol;


--
-- Name: scientificname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE scientificname (
    idscientificname integer NOT NULL,
    scientificname text NOT NULL,
    colvalidation boolean DEFAULT false
);


ALTER TABLE public.scientificname OWNER TO postgres;

--
-- Name: scientificnameauthorship; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE scientificnameauthorship (
    idscientificnameauthorship integer NOT NULL,
    scientificnameauthorship text NOT NULL,
    colvalidation boolean DEFAULT false
);


ALTER TABLE public.scientificnameauthorship OWNER TO postgres;

--
-- Name: scientificnameauthorships_idscientificnameauthorship_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE scientificnameauthorships_idscientificnameauthorship_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.scientificnameauthorships_idscientificnameauthorship_seq OWNER TO postgres;

--
-- Name: scientificnameauthorships_idscientificnameauthorship_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE scientificnameauthorships_idscientificnameauthorship_seq OWNED BY scientificnameauthorship.idscientificnameauthorship;


--
-- Name: scientificnames_idscientificname_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE scientificnames_idscientificname_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.scientificnames_idscientificname_seq OWNER TO postgres;

--
-- Name: scientificnames_idscientificname_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE scientificnames_idscientificname_seq OWNED BY scientificname.idscientificname;


--
-- Name: sex; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sex (
    idsex integer NOT NULL,
    sex text NOT NULL
);


ALTER TABLE public.sex OWNER TO postgres;

--
-- Name: sexes_idsex_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sexes_idsex_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.sexes_idsex_seq OWNER TO postgres;

--
-- Name: sexes_idsex_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sexes_idsex_seq OWNED BY sex.idsex;


--
-- Name: site_; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE site_ (
    idsite_ integer NOT NULL,
    site_ character varying
);


ALTER TABLE public.site_ OWNER TO postgres;

--
-- Name: site__idsite__seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE site__idsite__seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.site__idsite__seq OWNER TO postgres;

--
-- Name: site__idsite__seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE site__idsite__seq OWNED BY site_.idsite_;


--
-- Name: soilpreparation; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE soilpreparation (
    idsoilpreparation integer NOT NULL,
    soilpreparation character varying
);


ALTER TABLE public.soilpreparation OWNER TO postgres;

--
-- Name: soilpreparation_idsoilpreparation_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE soilpreparation_idsoilpreparation_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.soilpreparation_idsoilpreparation_seq OWNER TO postgres;

--
-- Name: soilpreparation_idsoilpreparation_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE soilpreparation_idsoilpreparation_seq OWNED BY soilpreparation.idsoilpreparation;


--
-- Name: soiltype; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE soiltype (
    idsoiltype integer NOT NULL,
    soiltype character varying
);


ALTER TABLE public.soiltype OWNER TO postgres;

--
-- Name: soiltype_idsoiltype_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE soiltype_idsoiltype_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.soiltype_idsoiltype_seq OWNER TO postgres;

--
-- Name: soiltype_idsoiltype_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE soiltype_idsoiltype_seq OWNED BY soiltype.idsoiltype;


--
-- Name: source_idsource_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE source_idsource_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.source_idsource_seq OWNER TO postgres;

--
-- Name: source_idsource_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE source_idsource_seq OWNED BY source.idsource;


--
-- Name: spatial_ref_sys; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE spatial_ref_sys (
    srid integer NOT NULL,
    auth_name character varying(256),
    auth_srid integer,
    srtext character varying(2048),
    proj4text character varying(2048)
);


ALTER TABLE public.spatial_ref_sys OWNER TO postgres;

--
-- Name: species; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE species (
    idspecies integer NOT NULL,
    abstract text,
    annualcycle text,
    authoryearofscientificname character varying,
    behavior text,
    benefits text,
    briefdescription text,
    chromosomicnumber text,
    comprehensivedescription text,
    conservationstatus text,
    datecreated date,
    datelastmodified date,
    distribution text,
    ecologicalsignificance text,
    endemicity text,
    feeding text,
    folklore text,
    lsid text,
    habit text,
    interactions text,
    invasivenessdata text,
    legislation text,
    lifecycle text,
    lifeexpectancy text,
    management text,
    migratorydata text,
    moleculardata text,
    morphology text,
    occurrence text,
    otherinformationsources text,
    populationbiology text,
    reproduction text,
    scientificdescription text,
    size character varying,
    targetaudiences text,
    territory text,
    threatstatus text,
    typification text,
    unstructureddocumentation text,
    unstructurednaturalhistory text,
    uses text,
    version text,
    habitat text,
    idinstitutioncode integer,
    idlanguage integer,
    idtaxonomicelement integer,
    idgroup integer,
    aux integer
);


ALTER TABLE public.species OWNER TO postgres;

--
-- Name: specie_idspecie_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE specie_idspecie_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.specie_idspecie_seq OWNER TO postgres;

--
-- Name: specie_idspecie_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE specie_idspecie_seq OWNED BY species.idspecies;


--
-- Name: speciescontributor; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE speciescontributor (
    idspecies integer NOT NULL,
    idcontributor integer NOT NULL
);


ALTER TABLE public.speciescontributor OWNER TO postgres;

--
-- Name: speciescreator; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE speciescreator (
    idspecies integer NOT NULL,
    idcreator integer NOT NULL
);


ALTER TABLE public.speciescreator OWNER TO postgres;

--
-- Name: speciesidkey; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE speciesidkey (
    idspecies integer NOT NULL,
    idreferenceelement integer NOT NULL
);


ALTER TABLE public.speciesidkey OWNER TO postgres;

--
-- Name: speciesmedia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE speciesmedia (
    idspecies integer NOT NULL,
    idmedia integer NOT NULL
);


ALTER TABLE public.speciesmedia OWNER TO postgres;

--
-- Name: speciesname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE speciesname (
    idspeciesname integer NOT NULL,
    speciesname character varying
);


ALTER TABLE public.speciesname OWNER TO postgres;

--
-- Name: speciesname_idspeciesname_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE speciesname_idspeciesname_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.speciesname_idspeciesname_seq OWNER TO postgres;

--
-- Name: speciesname_idspeciesname_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE speciesname_idspeciesname_seq OWNED BY speciesname.idspeciesname;


--
-- Name: speciespaper; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE speciespaper (
    idspecies integer NOT NULL,
    idreferenceelement integer NOT NULL
);


ALTER TABLE public.speciespaper OWNER TO postgres;

--
-- Name: speciespublicationreference; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE speciespublicationreference (
    idspecies integer NOT NULL,
    idreferenceelement integer NOT NULL
);


ALTER TABLE public.speciespublicationreference OWNER TO postgres;

--
-- Name: speciesreference; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE speciesreference (
    idspecies integer NOT NULL,
    idreferenceelement integer NOT NULL
);


ALTER TABLE public.speciesreference OWNER TO postgres;

--
-- Name: speciesrelatedname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE speciesrelatedname (
    idspecies integer NOT NULL,
    idrelatedname integer NOT NULL
);


ALTER TABLE public.speciesrelatedname OWNER TO postgres;

--
-- Name: speciessynonym; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE speciessynonym (
    idspecies integer NOT NULL,
    idsynonym integer NOT NULL
);


ALTER TABLE public.speciessynonym OWNER TO postgres;

--
-- Name: specificepithet; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE specificepithet (
    idspecificepithet integer NOT NULL,
    specificepithet text NOT NULL,
    colvalidation boolean DEFAULT false
);


ALTER TABLE public.specificepithet OWNER TO postgres;

--
-- Name: specificepithets_idspecificepithet_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE specificepithets_idspecificepithet_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.specificepithets_idspecificepithet_seq OWNER TO postgres;

--
-- Name: specificepithets_idspecificepithet_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE specificepithets_idspecificepithet_seq OWNED BY specificepithet.idspecificepithet;


--
-- Name: specimenelement_idspecimenelement_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE specimenelement_idspecimenelement_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.specimenelement_idspecimenelement_seq OWNER TO postgres;

--
-- Name: specimenelement_idspecimenelement_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE specimenelement_idspecimenelement_seq OWNED BY specimen.idspecimen;


--
-- Name: specimenmedia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE specimenmedia (
    idspecimen integer NOT NULL,
    idmedia integer NOT NULL
);


ALTER TABLE public.specimenmedia OWNER TO postgres;

--
-- Name: specimenreference; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE specimenreference (
    idspecimen integer NOT NULL,
    idreferenceelement integer NOT NULL
);


ALTER TABLE public.specimenreference OWNER TO postgres;

--
-- Name: stateprovince; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE stateprovince (
    idstateprovince integer NOT NULL,
    stateprovince text NOT NULL,
    googlevalidation boolean DEFAULT false,
    geonamesvalidation boolean DEFAULT false,
    biogeomancervalidation boolean DEFAULT false
);


ALTER TABLE public.stateprovince OWNER TO postgres;

--
-- Name: stateprovinces_idstateprovince_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stateprovinces_idstateprovince_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.stateprovinces_idstateprovince_seq OWNER TO postgres;

--
-- Name: stateprovinces_idstateprovince_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE stateprovinces_idstateprovince_seq OWNED BY stateprovince.idstateprovince;


--
-- Name: subcategorymedia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE subcategorymedia (
    idsubcategorymedia integer NOT NULL,
    subcategorymedia character varying(128) NOT NULL
);


ALTER TABLE public.subcategorymedia OWNER TO postgres;

--
-- Name: subcategorymedia_idsubcategorymedia_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE subcategorymedia_idsubcategorymedia_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.subcategorymedia_idsubcategorymedia_seq OWNER TO postgres;

--
-- Name: subcategorymedia_idsubcategorymedia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE subcategorymedia_idsubcategorymedia_seq OWNED BY subcategorymedia.idsubcategorymedia;


--
-- Name: subcategoryreference; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE subcategoryreference (
    idsubcategoryreference integer NOT NULL,
    subcategoryreference character varying(64) NOT NULL
);


ALTER TABLE public.subcategoryreference OWNER TO postgres;

--
-- Name: subcategoryreference_idsubcategoryreference_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE subcategoryreference_idsubcategoryreference_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.subcategoryreference_idsubcategoryreference_seq OWNER TO postgres;

--
-- Name: subcategoryreference_idsubcategoryreference_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE subcategoryreference_idsubcategoryreference_seq OWNED BY subcategoryreference.idsubcategoryreference;


--
-- Name: subgenus; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE subgenus (
    idsubgenus integer NOT NULL,
    subgenus character varying(120),
    colvalidation boolean DEFAULT false
);


ALTER TABLE public.subgenus OWNER TO postgres;

--
-- Name: subgenus_idsubgenus_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE subgenus_idsubgenus_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.subgenus_idsubgenus_seq OWNER TO postgres;

--
-- Name: subgenus_idsubgenus_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE subgenus_idsubgenus_seq OWNED BY subgenus.idsubgenus;


--
-- Name: subjectcategory; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE subjectcategory (
    idsubjectcategory integer NOT NULL,
    subjectcategory character varying(50)
);


ALTER TABLE public.subjectcategory OWNER TO postgres;

--
-- Name: subjectcategory_idsubjectcategory_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE subjectcategory_idsubjectcategory_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.subjectcategory_idsubjectcategory_seq OWNER TO postgres;

--
-- Name: subjectcategory_idsubjectcategory_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE subjectcategory_idsubjectcategory_seq OWNED BY subjectcategory.idsubjectcategory;


--
-- Name: subspecies; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE subspecies (
    idsubspecies integer NOT NULL,
    subspecies character varying
);


ALTER TABLE public.subspecies OWNER TO postgres;

--
-- Name: subspecies_idsubspecies_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE subspecies_idsubspecies_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.subspecies_idsubspecies_seq OWNER TO postgres;

--
-- Name: subspecies_idsubspecies_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE subspecies_idsubspecies_seq OWNED BY subspecies.idsubspecies;


--
-- Name: subtribe; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE subtribe (
    idsubtribe integer NOT NULL,
    subtribe character varying
);


ALTER TABLE public.subtribe OWNER TO postgres;

--
-- Name: subtribe_idsubtribe_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE subtribe_idsubtribe_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.subtribe_idsubtribe_seq OWNER TO postgres;

--
-- Name: subtribe_idsubtribe_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE subtribe_idsubtribe_seq OWNED BY subtribe.idsubtribe;


--
-- Name: subtype; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE subtype (
    idsubtype integer NOT NULL,
    subtype character varying(50)
);


ALTER TABLE public.subtype OWNER TO postgres;

--
-- Name: subtype_idsubtype_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE subtype_idsubtype_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.subtype_idsubtype_seq OWNER TO postgres;

--
-- Name: subtype_idsubtype_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE subtype_idsubtype_seq OWNED BY subtype.idsubtype;


--
-- Name: subtypereferences_idsubtypereferences_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE subtypereferences_idsubtypereferences_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.subtypereferences_idsubtypereferences_seq OWNER TO postgres;

--
-- Name: subtypereferences_idsubtypereferences_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE subtypereferences_idsubtypereferences_seq OWNED BY subtypereference.idsubtypereference;


--
-- Name: supporttype; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE supporttype (
    idsupporttype integer NOT NULL,
    supporttype character varying
);


ALTER TABLE public.supporttype OWNER TO postgres;

--
-- Name: supporttype_idsupporttype_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE supporttype_idsupporttype_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.supporttype_idsupporttype_seq OWNER TO postgres;

--
-- Name: supporttype_idsupporttype_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE supporttype_idsupporttype_seq OWNED BY supporttype.idsupporttype;


--
-- Name: surroundingsculture; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE surroundingsculture (
    idsurroundingsculture integer NOT NULL,
    surroundingsculture character varying
);


ALTER TABLE public.surroundingsculture OWNER TO postgres;

--
-- Name: surroundingsculture_idsurroundingsculture_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE surroundingsculture_idsurroundingsculture_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.surroundingsculture_idsurroundingsculture_seq OWNER TO postgres;

--
-- Name: surroundingsculture_idsurroundingsculture_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE surroundingsculture_idsurroundingsculture_seq OWNED BY surroundingsculture.idsurroundingsculture;


--
-- Name: surroundingsvegetation; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE surroundingsvegetation (
    idsurroundingsvegetation integer NOT NULL,
    surroundingsvegetation character varying
);


ALTER TABLE public.surroundingsvegetation OWNER TO postgres;

--
-- Name: surroundingsvegetation_idsurroundingsvegetation_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE surroundingsvegetation_idsurroundingsvegetation_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.surroundingsvegetation_idsurroundingsvegetation_seq OWNER TO postgres;

--
-- Name: surroundingsvegetation_idsurroundingsvegetation_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE surroundingsvegetation_idsurroundingsvegetation_seq OWNED BY surroundingsvegetation.idsurroundingsvegetation;


--
-- Name: synonym; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE synonym (
    idsynonym integer NOT NULL,
    synonym character varying
);


ALTER TABLE public.synonym OWNER TO postgres;

--
-- Name: synonym_idsynonym_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE synonym_idsynonym_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.synonym_idsynonym_seq OWNER TO postgres;

--
-- Name: synonym_idsynonym_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE synonym_idsynonym_seq OWNED BY synonym.idsynonym;


--
-- Name: tag; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tag (
    idtag integer NOT NULL,
    tag character varying(50)
);


ALTER TABLE public.tag OWNER TO postgres;

--
-- Name: tag_idtag_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tag_idtag_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.tag_idtag_seq OWNER TO postgres;

--
-- Name: tag_idtag_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tag_idtag_seq OWNED BY tag.idtag;


--
-- Name: taxonconcept; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE taxonconcept (
    idtaxonconcept integer NOT NULL,
    taxonconcept character varying(120)
);


ALTER TABLE public.taxonconcept OWNER TO postgres;

--
-- Name: taxonconcept_idtaxonconcept_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE taxonconcept_idtaxonconcept_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.taxonconcept_idtaxonconcept_seq OWNER TO postgres;

--
-- Name: taxonconcept_idtaxonconcept_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE taxonconcept_idtaxonconcept_seq OWNED BY taxonconcept.idtaxonconcept;


--
-- Name: taxonomicelement; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE taxonomicelement (
    idtaxonomicelement integer NOT NULL,
    idscientificname integer,
    idkingdom integer,
    idphylum integer,
    idclass integer,
    idorder integer,
    idfamily integer,
    idgenus integer,
    idspecificepithet integer,
    idinfraspecificepithet integer,
    idtaxonrank integer,
    idscientificnameauthorship integer,
    idnomenclaturalcode integer,
    higherclassification text NOT NULL,
    verbatimtaxonrank text,
    vernacularname character varying(80),
    nomenclaturalstatus character varying(60),
    taxonremark text,
    idacceptednameusage integer,
    idparentnameusage integer,
    idoriginalnameusage integer,
    idnameaccordingto integer,
    idnamepublishedin integer,
    idtaxonconcept integer,
    idsubgenus integer,
    idtaxonomicstatus integer,
    colvalidation boolean DEFAULT false,
    uncertainty integer,
    idmorphospecies integer,
    idtribe integer,
    idspeciesname integer,
    idsubspecies integer,
    idsubtribe integer
);


ALTER TABLE public.taxonomicelement OWNER TO postgres;

--
-- Name: COLUMN taxonomicelement.colvalidation; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN taxonomicelement.colvalidation IS 'Hierarquia esta valido com o banco do CoL';


--
-- Name: taxonomicelementcommonname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE taxonomicelementcommonname (
    idtaxonomicelement integer NOT NULL,
    idcommonname integer NOT NULL
);


ALTER TABLE public.taxonomicelementcommonname OWNER TO postgres;

--
-- Name: taxonomicelementrelatedname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE taxonomicelementrelatedname (
    idrelatedname integer NOT NULL,
    idtaxonomicelement integer NOT NULL
);


ALTER TABLE public.taxonomicelementrelatedname OWNER TO postgres;

--
-- Name: taxonomicelements_idtaxonomicelements_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE taxonomicelements_idtaxonomicelements_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.taxonomicelements_idtaxonomicelements_seq OWNER TO postgres;

--
-- Name: taxonomicelements_idtaxonomicelements_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE taxonomicelements_idtaxonomicelements_seq OWNED BY taxonomicelement.idtaxonomicelement;


--
-- Name: taxonomicelementsynonym; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE taxonomicelementsynonym (
    idsynonym integer NOT NULL,
    idtaxonomicelement integer NOT NULL
);


ALTER TABLE public.taxonomicelementsynonym OWNER TO postgres;

--
-- Name: taxonomicstatus; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE taxonomicstatus (
    idtaxonomicstatus integer NOT NULL,
    taxonomicstatus character varying(120)
);


ALTER TABLE public.taxonomicstatus OWNER TO postgres;

--
-- Name: taxonomicstatus_idtaxonomicstatus_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE taxonomicstatus_idtaxonomicstatus_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.taxonomicstatus_idtaxonomicstatus_seq OWNER TO postgres;

--
-- Name: taxonomicstatus_idtaxonomicstatus_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE taxonomicstatus_idtaxonomicstatus_seq OWNED BY taxonomicstatus.idtaxonomicstatus;


--
-- Name: taxonrank; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE taxonrank (
    idtaxonrank integer NOT NULL,
    taxonrank text NOT NULL
);


ALTER TABLE public.taxonrank OWNER TO postgres;

--
-- Name: taxonranks_idtaxonrank_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE taxonranks_idtaxonrank_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.taxonranks_idtaxonrank_seq OWNER TO postgres;

--
-- Name: taxonranks_idtaxonrank_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE taxonranks_idtaxonrank_seq OWNED BY taxonrank.idtaxonrank;


--
-- Name: technicalcollection; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE technicalcollection (
    idtechnicalcollection integer NOT NULL,
    technicalcollection character varying
);


ALTER TABLE public.technicalcollection OWNER TO postgres;

--
-- Name: technicalcollection_idtechnicalcollection_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE technicalcollection_idtechnicalcollection_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.technicalcollection_idtechnicalcollection_seq OWNER TO postgres;

--
-- Name: technicalcollection_idtechnicalcollection_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE technicalcollection_idtechnicalcollection_seq OWNED BY technicalcollection.idtechnicalcollection;


--
-- Name: temp; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE temp (
    id integer,
    nome text
);


ALTER TABLE public.temp OWNER TO postgres;

--
-- Name: topograficalsituation; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE topograficalsituation (
    idtopograficalsituation integer NOT NULL,
    topograficalsituation character varying
);


ALTER TABLE public.topograficalsituation OWNER TO postgres;

--
-- Name: topograficalsituation_idtopograficalsituation_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE topograficalsituation_idtopograficalsituation_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.topograficalsituation_idtopograficalsituation_seq OWNER TO postgres;

--
-- Name: topograficalsituation_idtopograficalsituation_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE topograficalsituation_idtopograficalsituation_seq OWNED BY topograficalsituation.idtopograficalsituation;


--
-- Name: treatment; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE treatment (
    idtreatment integer NOT NULL,
    treatment character varying
);


ALTER TABLE public.treatment OWNER TO postgres;

--
-- Name: treatment_idtreatment_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE treatment_idtreatment_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.treatment_idtreatment_seq OWNER TO postgres;

--
-- Name: treatment_idtreatment_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE treatment_idtreatment_seq OWNED BY treatment.idtreatment;


--
-- Name: tribe; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tribe (
    tribe character varying,
    idtribe integer NOT NULL
);


ALTER TABLE public.tribe OWNER TO postgres;

--
-- Name: tribe_idtribe_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tribe_idtribe_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.tribe_idtribe_seq OWNER TO postgres;

--
-- Name: tribe_idtribe_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tribe_idtribe_seq OWNED BY tribe.idtribe;


--
-- Name: type; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE type (
    idtype integer NOT NULL,
    type character varying(100)
);


ALTER TABLE public.type OWNER TO postgres;

--
-- Name: type_log_dq; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE type_log_dq (
    id integer NOT NULL,
    description character varying(200) NOT NULL
);


ALTER TABLE public.type_log_dq OWNER TO postgres;

--
-- Name: type_log_dq_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE type_log_dq_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.type_log_dq_id_seq OWNER TO postgres;

--
-- Name: type_log_dq_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE type_log_dq_id_seq OWNED BY type_log_dq.id;


--
-- Name: typeholding; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE typeholding (
    idtypeholding integer NOT NULL,
    typeholding character varying
);


ALTER TABLE public.typeholding OWNER TO postgres;

--
-- Name: typeholding_idtypeholding_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE typeholding_idtypeholding_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.typeholding_idtypeholding_seq OWNER TO postgres;

--
-- Name: typeholding_idtypeholding_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE typeholding_idtypeholding_seq OWNED BY typeholding.idtypeholding;


--
-- Name: typemedia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE typemedia (
    idtypemedia integer NOT NULL,
    typemedia character varying(80)
);


ALTER TABLE public.typemedia OWNER TO postgres;

--
-- Name: typemedia_idtypemedia_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE typemedia_idtypemedia_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.typemedia_idtypemedia_seq OWNER TO postgres;

--
-- Name: typemedia_idtypemedia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE typemedia_idtypemedia_seq OWNED BY typemedia.idtypemedia;


--
-- Name: typeplanting; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE typeplanting (
    idtypeplanting integer NOT NULL,
    typeplanting character varying
);


ALTER TABLE public.typeplanting OWNER TO postgres;

--
-- Name: typeplanting_idtypeplanting_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE typeplanting_idtypeplanting_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.typeplanting_idtypeplanting_seq OWNER TO postgres;

--
-- Name: typeplanting_idtypeplanting_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE typeplanting_idtypeplanting_seq OWNED BY typeplanting.idtypeplanting;


--
-- Name: typereferences_idtypereferences_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE typereferences_idtypereferences_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.typereferences_idtypereferences_seq OWNER TO postgres;

--
-- Name: typereferences_idtypereferences_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE typereferences_idtypereferences_seq OWNED BY typereference.idtypereference;


--
-- Name: types_idtypes_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE types_idtypes_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.types_idtypes_seq OWNER TO postgres;

--
-- Name: types_idtypes_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE types_idtypes_seq OWNED BY type.idtype;


--
-- Name: typestand; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE typestand (
    idtypestand integer NOT NULL,
    typestand character varying
);


ALTER TABLE public.typestand OWNER TO postgres;

--
-- Name: typestand_idtypestand_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE typestand_idtypestand_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.typestand_idtypestand_seq OWNER TO postgres;

--
-- Name: typestand_idtypestand_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE typestand_idtypestand_seq OWNED BY typestand.idtypestand;


--
-- Name: typestatus; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE typestatus (
    idtypestatus integer NOT NULL,
    typestatus character varying(120)
);


ALTER TABLE public.typestatus OWNER TO postgres;

--
-- Name: typestatus_idtypestatus_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE typestatus_idtypestatus_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.typestatus_idtypestatus_seq OWNER TO postgres;

--
-- Name: typestatus_idtypestatus_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE typestatus_idtypestatus_seq OWNED BY typestatus.idtypestatus;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    "idUser" integer NOT NULL,
    "idGroup" integer NOT NULL,
    username character varying(50) NOT NULL,
    password text NOT NULL,
    email text NOT NULL,
    "idUserAdd" integer,
    "dateValidated" timestamp without time zone,
    modified date
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_idUser_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "users_idUser_seq"
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public."users_idUser_seq" OWNER TO postgres;

--
-- Name: users_idUser_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "users_idUser_seq" OWNED BY users."idUser";


--
-- Name: validacao; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE validacao (
    idvalidacao integer NOT NULL,
    "tabelaOrigem" character varying(50) NOT NULL,
    "idElementoOriginal" character varying(50) NOT NULL,
    ordem character(1) NOT NULL,
    "idElementoNovo" integer NOT NULL,
    "dataInclusao" timestamp without time zone NOT NULL,
    "idUsuario" integer NOT NULL,
    "idValidador" integer NOT NULL,
    "dataValidacao" timestamp without time zone NOT NULL,
    observacao text
);


ALTER TABLE public.validacao OWNER TO postgres;

--
-- Name: validacao_idvalidacao_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE validacao_idvalidacao_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.validacao_idvalidacao_seq OWNER TO postgres;

--
-- Name: validacao_idvalidacao_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE validacao_idvalidacao_seq OWNED BY validacao.idvalidacao;


--
-- Name: waterbody; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE waterbody (
    idwaterbody integer NOT NULL,
    waterbody text NOT NULL,
    geonamesvalidation boolean DEFAULT false
);


ALTER TABLE public.waterbody OWNER TO postgres;

--
-- Name: waterbodies_idwaterbody_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE waterbodies_idwaterbody_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.waterbodies_idwaterbody_seq OWNER TO postgres;

--
-- Name: waterbodies_idwaterbody_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE waterbodies_idwaterbody_seq OWNED BY waterbody.idwaterbody;


--
-- Name: weathercondition; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE weathercondition (
    idweathercondition integer NOT NULL,
    weathercondition character varying
);


ALTER TABLE public.weathercondition OWNER TO postgres;

--
-- Name: weathercondition_idweathercondition_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE weathercondition_idweathercondition_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.weathercondition_idweathercondition_seq OWNER TO postgres;

--
-- Name: weathercondition_idweathercondition_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE weathercondition_idweathercondition_seq OWNED BY weathercondition.idweathercondition;


--
-- Name: idacceptednameusage; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY acceptednameusage ALTER COLUMN idacceptednameusage SET DEFAULT nextval('acceptednameusage_idacceptednameusage_seq'::regclass);


--
-- Name: idaccrualmethod; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY accrualmethod ALTER COLUMN idaccrualmethod SET DEFAULT nextval('accuralmethods_idaccuralmethods_seq'::regclass);


--
-- Name: idaccrualperiodicity; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY accrualperiodicity ALTER COLUMN idaccrualperiodicity SET DEFAULT nextval('accuralperiodicities_idaccuralperiodicities_seq'::regclass);


--
-- Name: idaccrualpolicy; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY accrualpolicy ALTER COLUMN idaccrualpolicy SET DEFAULT nextval('accuralpolicies_idaccuralpolicies_seq'::regclass);


--
-- Name: idafiliation; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY afiliation ALTER COLUMN idafiliation SET DEFAULT nextval('"Afiliation_idafiliation_seq"'::regclass);


--
-- Name: idannualcycle; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY annualcycle ALTER COLUMN idannualcycle SET DEFAULT nextval('annualcycle_idannualcycle_seq'::regclass);


--
-- Name: idassociatedsequence; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedsequence ALTER COLUMN idassociatedsequence SET DEFAULT nextval('associatedsequence_idassociatedsequence_seq'::regclass);


--
-- Name: idattributes; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY attributes ALTER COLUMN idattributes SET DEFAULT nextval('"attribute_idAttribute_seq"'::regclass);


--
-- Name: idaudience; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY audience ALTER COLUMN idaudience SET DEFAULT nextval('audiences_idaudiences_seq'::regclass);


--
-- Name: idbasisofrecord; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY basisofrecord ALTER COLUMN idbasisofrecord SET DEFAULT nextval('basisofrecords_idbasisofrecord_seq'::regclass);


--
-- Name: idbehavior; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY behavior ALTER COLUMN idbehavior SET DEFAULT nextval('behavior_idbehavior_seq'::regclass);


--
-- Name: idbiome; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY biome ALTER COLUMN idbiome SET DEFAULT nextval('biome_idbiome_seq'::regclass);


--
-- Name: idcanonicalauthorship; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY canonicalauthorship ALTER COLUMN idcanonicalauthorship SET DEFAULT nextval('canonicalauthorship_idcanonicalauthorship_seq'::regclass);


--
-- Name: idcanonicalname; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY canonicalname ALTER COLUMN idcanonicalname SET DEFAULT nextval('canonicalnames_idcanonicalnames_seq'::regclass);


--
-- Name: idcapturedevice; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY capturedevice ALTER COLUMN idcapturedevice SET DEFAULT nextval('capturedevice_idcapturedevice_seq'::regclass);


--
-- Name: idcategorymedia; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY categorymedia ALTER COLUMN idcategorymedia SET DEFAULT nextval('categorymedia_idcategorymedia_seq'::regclass);


--
-- Name: idcategoryreference; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY categoryreference ALTER COLUMN idcategoryreference SET DEFAULT nextval('categoryreference_idcategoryreference_seq'::regclass);


--
-- Name: idclass; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY class ALTER COLUMN idclass SET DEFAULT nextval('classes_idclass_seq'::regclass);


--
-- Name: idcollectedby; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY collectedby ALTER COLUMN idcollectedby SET DEFAULT nextval('recordedby_idrecordedby_seq'::regclass);


--
-- Name: idcollectioncode; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY collectioncode ALTER COLUMN idcollectioncode SET DEFAULT nextval('collectioncodes_idcollectioncode_seq'::regclass);


--
-- Name: idcollector; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY collector ALTER COLUMN idcollector SET DEFAULT nextval('collector_idcollector_seq'::regclass);


--
-- Name: idcolorpantrap; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY colorpantrap ALTER COLUMN idcolorpantrap SET DEFAULT nextval('colorpantrap_idcolorpantrap_seq'::regclass);


--
-- Name: idcommonname; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY commonname ALTER COLUMN idcommonname SET DEFAULT nextval('commonnames_idcommonnames_seq'::regclass);


--
-- Name: idcommonnamefocalcrop; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY commonnamefocalcrop ALTER COLUMN idcommonnamefocalcrop SET DEFAULT nextval('commonnamefocalcrop_idcommonnamefocalcrop_seq'::regclass);


--
-- Name: idcontinent; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY continent ALTER COLUMN idcontinent SET DEFAULT nextval('continents_idcontinent_seq'::regclass);


--
-- Name: idcontributor; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY contributor ALTER COLUMN idcontributor SET DEFAULT nextval('contributors_idcontributors_seq'::regclass);


--
-- Name: idcountry; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY country ALTER COLUMN idcountry SET DEFAULT nextval('countries_idcountry_seq'::regclass);


--
-- Name: idcounty; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY county ALTER COLUMN idcounty SET DEFAULT nextval('counties_idcounty_seq'::regclass);


--
-- Name: idcreator; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY creator ALTER COLUMN idcreator SET DEFAULT nextval('creators_idcreators_seq'::regclass);


--
-- Name: idcultivar; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cultivar ALTER COLUMN idcultivar SET DEFAULT nextval('cultivar_idcultivar_seq'::regclass);


--
-- Name: idculture; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY culture ALTER COLUMN idculture SET DEFAULT nextval('culture_idculture_seq'::regclass);


--
-- Name: idcuratorialelement; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialelement ALTER COLUMN idcuratorialelement SET DEFAULT nextval('curatorialelements_idcuratorialelements_seq'::regclass);


--
-- Name: iddataset; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dataset ALTER COLUMN iddataset SET DEFAULT nextval('dataset_iddataset_seq'::regclass);


--
-- Name: iddeficit; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit ALTER COLUMN iddeficit SET DEFAULT nextval('deficit_iddeficit_seq'::regclass);


--
-- Name: iddenomination; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY denomination ALTER COLUMN iddenomination SET DEFAULT nextval('denomination_iddenomination_seq'::regclass);


--
-- Name: iddigitizer; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY digitizer ALTER COLUMN iddigitizer SET DEFAULT nextval('digitizer_iddigitizer_seq'::regclass);


--
-- Name: iddisease; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY disease ALTER COLUMN iddisease SET DEFAULT nextval('diseases_iddiseases_seq'::regclass);


--
-- Name: iddispersal; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dispersal ALTER COLUMN iddispersal SET DEFAULT nextval('dispersals_iddispersal_seq'::regclass);


--
-- Name: iddisposition; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY disposition ALTER COLUMN iddisposition SET DEFAULT nextval('disposition_iddisposition_seq'::regclass);


--
-- Name: iddynamicproperty; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dynamicproperty ALTER COLUMN iddynamicproperty SET DEFAULT nextval('dynamicproperties_iddynamicproperties_seq'::regclass);


--
-- Name: idestablishmentmean; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY establishmentmean ALTER COLUMN idestablishmentmean SET DEFAULT nextval('establishmentmeanss_idestablishmentmeans_seq'::regclass);


--
-- Name: ideventelement; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY eventelement ALTER COLUMN ideventelement SET DEFAULT nextval('eventelements_ideventelements_seq'::regclass);


--
-- Name: idfamily; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY family ALTER COLUMN idfamily SET DEFAULT nextval('families_idfamily_seq'::regclass);


--
-- Name: idfile; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY file ALTER COLUMN idfile SET DEFAULT nextval('files_idfile_seq'::regclass);


--
-- Name: idfileformat; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY fileformat ALTER COLUMN idfileformat SET DEFAULT nextval('fileformats_idfileformats_seq'::regclass);


--
-- Name: idfocuscrop; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY focuscrop ALTER COLUMN idfocuscrop SET DEFAULT nextval('focuscrop_idfocuscrop_seq'::regclass);


--
-- Name: idformatmedia; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY formatmedia ALTER COLUMN idformatmedia SET DEFAULT nextval('formatmedia_idformatmedia_seq'::regclass);


--
-- Name: idgenus; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY genus ALTER COLUMN idgenus SET DEFAULT nextval('genus_idgenus_seq'::regclass);


--
-- Name: idgeoreferencedby; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY georeferencedby ALTER COLUMN idgeoreferencedby SET DEFAULT nextval('georeferedby_idgeoreferdby_seq'::regclass);


--
-- Name: idgeoreferencesource; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY georeferencesource ALTER COLUMN idgeoreferencesource SET DEFAULT nextval('georeferencesources_idgeoreferencesources_seq'::regclass);


--
-- Name: idgeoreferenceverificationstatus; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY georeferenceverificationstatus ALTER COLUMN idgeoreferenceverificationstatus SET DEFAULT nextval('georeferenceverificationstatu_idgeoreferenceverificationsta_seq'::regclass);


--
-- Name: idgeospatialelement; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY geospatialelement ALTER COLUMN idgeospatialelement SET DEFAULT nextval('geospatialelements_idgeospatialelements_seq'::regclass);


--
-- Name: idGroup; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY groups ALTER COLUMN "idGroup" SET DEFAULT nextval('"groups_idGroup_seq"'::regclass);


--
-- Name: idhabitat; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY habitat ALTER COLUMN idhabitat SET DEFAULT nextval('habitats_idhabitat_seq'::regclass);


--
-- Name: ididentificationelement; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY identificationelement ALTER COLUMN ididentificationelement SET DEFAULT nextval('identificationelements_ididentificationelements_seq'::regclass);


--
-- Name: ididentificationqualifier; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY identificationqualifier ALTER COLUMN ididentificationqualifier SET DEFAULT nextval('identificationqualifiers_ididentificationqualifier_seq'::regclass);


--
-- Name: ididentifiedby; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY identifiedby ALTER COLUMN ididentifiedby SET DEFAULT nextval('identifiedby_ididentifiedby_seq'::regclass);


--
-- Name: idindividual; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY individual ALTER COLUMN idindividual SET DEFAULT nextval('individual_idindividual_seq'::regclass);


--
-- Name: idinfraspecificepithet; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY infraspecificepithet ALTER COLUMN idinfraspecificepithet SET DEFAULT nextval('infraspecificepithets_idinfraspecificepithet_seq'::regclass);


--
-- Name: idinstitutioncode; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY institutioncode ALTER COLUMN idinstitutioncode SET DEFAULT nextval('institutioncodes_idinstitutioncode_seq'::regclass);


--
-- Name: idinstructionalmethod; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY instructionalmethod ALTER COLUMN idinstructionalmethod SET DEFAULT nextval('instructionalmethods_idinstructionalmethods_seq'::regclass);


--
-- Name: idinteraction; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY interaction ALTER COLUMN idinteraction SET DEFAULT nextval('interactionelements_idinteractionelements_seq'::regclass);


--
-- Name: idinteractiontype; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY interactiontype ALTER COLUMN idinteractiontype SET DEFAULT nextval('interactiontypes_idinteractiontype_seq'::regclass);


--
-- Name: idisland; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY island ALTER COLUMN idisland SET DEFAULT nextval('islands_idisland_seq'::regclass);


--
-- Name: idislandgroup; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY islandgroup ALTER COLUMN idislandgroup SET DEFAULT nextval('islandgroups_idislandgroup_seq'::regclass);


--
-- Name: idkeyword; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY keyword ALTER COLUMN idkeyword SET DEFAULT nextval('keyword_idkeyword_seq'::regclass);


--
-- Name: idkingdom; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY kingdom ALTER COLUMN idkingdom SET DEFAULT nextval('kingdom_idkingdom_seq'::regclass);


--
-- Name: idlanguage; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY language ALTER COLUMN idlanguage SET DEFAULT nextval('languages_idlanguages_seq'::regclass);


--
-- Name: idlicense; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY license ALTER COLUMN idlicense SET DEFAULT nextval('licenses_idlicenses_seq'::regclass);


--
-- Name: idlifecycle; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY lifecycle ALTER COLUMN idlifecycle SET DEFAULT nextval('lifecycles_idlifecycles_seq'::regclass);


--
-- Name: idlifeexpectancy; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY lifeexpectancy ALTER COLUMN idlifeexpectancy SET DEFAULT nextval('lifeexpectancies_idlifeexpectancies_seq'::regclass);


--
-- Name: idlifestage; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY lifestage ALTER COLUMN idlifestage SET DEFAULT nextval('lifestages_idlifestage_seq'::regclass);


--
-- Name: idlocality; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY locality ALTER COLUMN idlocality SET DEFAULT nextval('localities_idlocality_seq'::regclass);


--
-- Name: idlocalityelement; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement ALTER COLUMN idlocalityelement SET DEFAULT nextval('localityelements_idlocalityelements_seq'::regclass);


--
-- Name: idlog; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log ALTER COLUMN idlog SET DEFAULT nextval('log_idlog_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_dq ALTER COLUMN id SET DEFAULT nextval('log_dq_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_dq_deleted_items ALTER COLUMN id SET DEFAULT nextval('log_dq_deleted_items_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_dq_fields ALTER COLUMN id SET DEFAULT nextval('log_dq_fields_id_seq'::regclass);


--
-- Name: idmainplantspeciesinhedge; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mainplantspeciesinhedge ALTER COLUMN idmainplantspeciesinhedge SET DEFAULT nextval('mainplantspeciesinhedge_idmainplantspeciesinhedge_seq'::regclass);


--
-- Name: idmedia; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY media ALTER COLUMN idmedia SET DEFAULT nextval('media_idmedia_seq'::regclass);


--
-- Name: idmetadataprovider; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY metadataprovider ALTER COLUMN idmetadataprovider SET DEFAULT nextval('metadataprovider_idmetadataprovider_seq'::regclass);


--
-- Name: idmigration; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY migration ALTER COLUMN idmigration SET DEFAULT nextval('migrations_idmigration_seq'::regclass);


--
-- Name: idmonitoring; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring ALTER COLUMN idmonitoring SET DEFAULT nextval('monitoring_idmonitoring_seq'::regclass);


--
-- Name: idmorphospecies; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY morphospecies ALTER COLUMN idmorphospecies SET DEFAULT nextval('morphospecies_idmorphospecies_seq'::regclass);


--
-- Name: idmunicipality; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY municipality ALTER COLUMN idmunicipality SET DEFAULT nextval('municipality_idmunicipality_seq'::regclass);


--
-- Name: idnameaccordingto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY nameaccordingto ALTER COLUMN idnameaccordingto SET DEFAULT nextval('nameaccordingto_idnameaccordingto_seq'::regclass);


--
-- Name: idnamepublishedin; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY namepublishedin ALTER COLUMN idnamepublishedin SET DEFAULT nextval('namepublishedin_idnamepublishedin_seq'::regclass);


--
-- Name: idnomenclaturalcode; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY nomenclaturalcode ALTER COLUMN idnomenclaturalcode SET DEFAULT nextval('nomenclaturalcodes_idnomenclaturalcode_seq'::regclass);


--
-- Name: idobserver; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY observer ALTER COLUMN idobserver SET DEFAULT nextval('observer_idobserver_seq'::regclass);


--
-- Name: idoccurrenceelement; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement ALTER COLUMN idoccurrenceelement SET DEFAULT nextval('occurrence_idoccurrence_seq'::regclass);


--
-- Name: idorder; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "order" ALTER COLUMN idorder SET DEFAULT nextval('orders_idorder_seq'::regclass);


--
-- Name: idoriginalnameusage; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY originalnameusage ALTER COLUMN idoriginalnameusage SET DEFAULT nextval('originalnameusage_idoriginalnameusage_seq'::regclass);


--
-- Name: idoriginseeds; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY originseeds ALTER COLUMN idoriginseeds SET DEFAULT nextval('originseeds_idoriginseeds_seq'::regclass);


--
-- Name: idownerinstitution; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ownerinstitution ALTER COLUMN idownerinstitution SET DEFAULT nextval('ownerinstitution_idownerinstitution_seq'::regclass);


--
-- Name: idpage; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY page ALTER COLUMN idpage SET DEFAULT nextval('"pages_idPage_seq"'::regclass);


--
-- Name: idparentnameusage; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY parentnameusage ALTER COLUMN idparentnameusage SET DEFAULT nextval('parentnameusage_idparentnameusage_seq'::regclass);


--
-- Name: idphylum; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY phylum ALTER COLUMN idphylum SET DEFAULT nextval('phylums_idphylum_seq'::regclass);


--
-- Name: idplantcommonname; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY plantcommonname ALTER COLUMN idplantcommonname SET DEFAULT nextval('plantcommonname_idplantcommonname_seq'::regclass);


--
-- Name: idplantfamily; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY plantfamily ALTER COLUMN idplantfamily SET DEFAULT nextval('plantfamily_idplantfamily_seq'::regclass);


--
-- Name: idplantspecies; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY plantspecies ALTER COLUMN idplantspecies SET DEFAULT nextval('plantspecies_idplantspecies_seq'::regclass);


--
-- Name: idpollinatorcommonname; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pollinatorcommonname ALTER COLUMN idpollinatorcommonname SET DEFAULT nextval('pollinatorcommonname_idpollinatorcommonname_seq'::regclass);


--
-- Name: idpollinatorfamily; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pollinatorfamily ALTER COLUMN idpollinatorfamily SET DEFAULT nextval('pollinatorfamily_idpollinatorfamily_seq'::regclass);


--
-- Name: idpollinatorspecies; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pollinatorspecies ALTER COLUMN idpollinatorspecies SET DEFAULT nextval('pollinatorspecies_idpollinatorspecies_seq'::regclass);


--
-- Name: idpredominantbiome; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY predominantbiome ALTER COLUMN idpredominantbiome SET DEFAULT nextval('predominantbiome_idpredominantbiome_seq'::regclass);


--
-- Name: idpreparation; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY preparation ALTER COLUMN idpreparation SET DEFAULT nextval('preparations_idpreparations_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY process_log_dq ALTER COLUMN id SET DEFAULT nextval('process_log_dq_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY process_specimens_execution ALTER COLUMN id SET DEFAULT nextval('process_specimens_execution_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY process_taxons_execution ALTER COLUMN id SET DEFAULT nextval('process_taxons_execution_id_seq'::regclass);


--
-- Name: idproductionvariety; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY productionvariety ALTER COLUMN idproductionvariety SET DEFAULT nextval('productionvariety_idproductionvariety_seq'::regclass);


--
-- Name: idprovider; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY provider ALTER COLUMN idprovider SET DEFAULT nextval('provider_idprovider_seq'::regclass);


--
-- Name: idpublisher; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY publisher ALTER COLUMN idpublisher SET DEFAULT nextval('publishers_idpublishers_seq'::regclass);


--
-- Name: idrecordedby; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordedby ALTER COLUMN idrecordedby SET DEFAULT nextval('recordedby_idrecordedby_seq1'::regclass);


--
-- Name: idrecordlevelelement; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement ALTER COLUMN idrecordlevelelement SET DEFAULT nextval('recordlevelelements_idrecordlevelelements_seq'::regclass);


--
-- Name: idreferenceelement; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceelement ALTER COLUMN idreferenceelement SET DEFAULT nextval('referenceelement_idreferenceelement_seq'::regclass);


--
-- Name: idrelatedname; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY relatedname ALTER COLUMN idrelatedname SET DEFAULT nextval('relatedname_idrelatedname_seq'::regclass);


--
-- Name: idreproduction; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY reproduction ALTER COLUMN idreproduction SET DEFAULT nextval('reproductions_idreproduction_seq'::regclass);


--
-- Name: idreproductivecondition; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY reproductivecondition ALTER COLUMN idreproductivecondition SET DEFAULT nextval('reproductivecondition_idreproductivecondition_seq'::regclass);


--
-- Name: idsamplingprotocol; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY samplingprotocol ALTER COLUMN idsamplingprotocol SET DEFAULT nextval('samplingprotocols_idsamplingprotocol_seq'::regclass);


--
-- Name: idscientificname; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY scientificname ALTER COLUMN idscientificname SET DEFAULT nextval('scientificnames_idscientificname_seq'::regclass);


--
-- Name: idscientificnameauthorship; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY scientificnameauthorship ALTER COLUMN idscientificnameauthorship SET DEFAULT nextval('scientificnameauthorships_idscientificnameauthorship_seq'::regclass);


--
-- Name: idsex; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sex ALTER COLUMN idsex SET DEFAULT nextval('sexes_idsex_seq'::regclass);


--
-- Name: idsite_; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY site_ ALTER COLUMN idsite_ SET DEFAULT nextval('site__idsite__seq'::regclass);


--
-- Name: idsoilpreparation; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY soilpreparation ALTER COLUMN idsoilpreparation SET DEFAULT nextval('soilpreparation_idsoilpreparation_seq'::regclass);


--
-- Name: idsoiltype; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY soiltype ALTER COLUMN idsoiltype SET DEFAULT nextval('soiltype_idsoiltype_seq'::regclass);


--
-- Name: idsource; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY source ALTER COLUMN idsource SET DEFAULT nextval('source_idsource_seq'::regclass);


--
-- Name: idspecies; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY species ALTER COLUMN idspecies SET DEFAULT nextval('specie_idspecie_seq'::regclass);


--
-- Name: idspeciesname; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciesname ALTER COLUMN idspeciesname SET DEFAULT nextval('speciesname_idspeciesname_seq'::regclass);


--
-- Name: idspecificepithet; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specificepithet ALTER COLUMN idspecificepithet SET DEFAULT nextval('specificepithets_idspecificepithet_seq'::regclass);


--
-- Name: idspecimen; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen ALTER COLUMN idspecimen SET DEFAULT nextval('specimenelement_idspecimenelement_seq'::regclass);


--
-- Name: idstateprovince; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY stateprovince ALTER COLUMN idstateprovince SET DEFAULT nextval('stateprovinces_idstateprovince_seq'::regclass);


--
-- Name: idsubcategorymedia; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subcategorymedia ALTER COLUMN idsubcategorymedia SET DEFAULT nextval('subcategorymedia_idsubcategorymedia_seq'::regclass);


--
-- Name: idsubcategoryreference; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subcategoryreference ALTER COLUMN idsubcategoryreference SET DEFAULT nextval('subcategoryreference_idsubcategoryreference_seq'::regclass);


--
-- Name: idsubgenus; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subgenus ALTER COLUMN idsubgenus SET DEFAULT nextval('subgenus_idsubgenus_seq'::regclass);


--
-- Name: idsubjectcategory; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subjectcategory ALTER COLUMN idsubjectcategory SET DEFAULT nextval('subjectcategory_idsubjectcategory_seq'::regclass);


--
-- Name: idsubspecies; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subspecies ALTER COLUMN idsubspecies SET DEFAULT nextval('subspecies_idsubspecies_seq'::regclass);


--
-- Name: idsubtribe; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subtribe ALTER COLUMN idsubtribe SET DEFAULT nextval('subtribe_idsubtribe_seq'::regclass);


--
-- Name: idsubtype; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subtype ALTER COLUMN idsubtype SET DEFAULT nextval('subtype_idsubtype_seq'::regclass);


--
-- Name: idsubtypereference; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY subtypereference ALTER COLUMN idsubtypereference SET DEFAULT nextval('subtypereferences_idsubtypereferences_seq'::regclass);


--
-- Name: idsupporttype; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY supporttype ALTER COLUMN idsupporttype SET DEFAULT nextval('supporttype_idsupporttype_seq'::regclass);


--
-- Name: idsurroundingsculture; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY surroundingsculture ALTER COLUMN idsurroundingsculture SET DEFAULT nextval('surroundingsculture_idsurroundingsculture_seq'::regclass);


--
-- Name: idsurroundingsvegetation; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY surroundingsvegetation ALTER COLUMN idsurroundingsvegetation SET DEFAULT nextval('surroundingsvegetation_idsurroundingsvegetation_seq'::regclass);


--
-- Name: idsynonym; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY synonym ALTER COLUMN idsynonym SET DEFAULT nextval('synonym_idsynonym_seq'::regclass);


--
-- Name: idtag; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tag ALTER COLUMN idtag SET DEFAULT nextval('tag_idtag_seq'::regclass);


--
-- Name: idtaxonconcept; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonconcept ALTER COLUMN idtaxonconcept SET DEFAULT nextval('taxonconcept_idtaxonconcept_seq'::regclass);


--
-- Name: idtaxonomicelement; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement ALTER COLUMN idtaxonomicelement SET DEFAULT nextval('taxonomicelements_idtaxonomicelements_seq'::regclass);


--
-- Name: idtaxonomicstatus; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicstatus ALTER COLUMN idtaxonomicstatus SET DEFAULT nextval('taxonomicstatus_idtaxonomicstatus_seq'::regclass);


--
-- Name: idtaxonrank; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonrank ALTER COLUMN idtaxonrank SET DEFAULT nextval('taxonranks_idtaxonrank_seq'::regclass);


--
-- Name: idtechnicalcollection; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY technicalcollection ALTER COLUMN idtechnicalcollection SET DEFAULT nextval('technicalcollection_idtechnicalcollection_seq'::regclass);


--
-- Name: idtopograficalsituation; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY topograficalsituation ALTER COLUMN idtopograficalsituation SET DEFAULT nextval('topograficalsituation_idtopograficalsituation_seq'::regclass);


--
-- Name: idtreatment; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY treatment ALTER COLUMN idtreatment SET DEFAULT nextval('treatment_idtreatment_seq'::regclass);


--
-- Name: idtribe; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tribe ALTER COLUMN idtribe SET DEFAULT nextval('tribe_idtribe_seq'::regclass);


--
-- Name: idtype; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY type ALTER COLUMN idtype SET DEFAULT nextval('types_idtypes_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY type_log_dq ALTER COLUMN id SET DEFAULT nextval('type_log_dq_id_seq'::regclass);


--
-- Name: idtypeholding; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY typeholding ALTER COLUMN idtypeholding SET DEFAULT nextval('typeholding_idtypeholding_seq'::regclass);


--
-- Name: idtypemedia; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY typemedia ALTER COLUMN idtypemedia SET DEFAULT nextval('typemedia_idtypemedia_seq'::regclass);


--
-- Name: idtypeplanting; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY typeplanting ALTER COLUMN idtypeplanting SET DEFAULT nextval('typeplanting_idtypeplanting_seq'::regclass);


--
-- Name: idtypereference; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY typereference ALTER COLUMN idtypereference SET DEFAULT nextval('typereferences_idtypereferences_seq'::regclass);


--
-- Name: idtypestand; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY typestand ALTER COLUMN idtypestand SET DEFAULT nextval('typestand_idtypestand_seq'::regclass);


--
-- Name: idtypestatus; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY typestatus ALTER COLUMN idtypestatus SET DEFAULT nextval('typestatus_idtypestatus_seq'::regclass);


--
-- Name: idUser; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users ALTER COLUMN "idUser" SET DEFAULT nextval('"users_idUser_seq"'::regclass);


--
-- Name: idvalidacao; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY validacao ALTER COLUMN idvalidacao SET DEFAULT nextval('validacao_idvalidacao_seq'::regclass);


--
-- Name: idwaterbody; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY waterbody ALTER COLUMN idwaterbody SET DEFAULT nextval('waterbodies_idwaterbody_seq'::regclass);


--
-- Name: idweathercondition; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY weathercondition ALTER COLUMN idweathercondition SET DEFAULT nextval('weathercondition_idweathercondition_seq'::regclass);


--
-- Name: Afiliation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY afiliation
    ADD CONSTRAINT "Afiliation_pkey" PRIMARY KEY (idafiliation);


--
-- Name: acceptednameusage_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acceptednameusage
    ADD CONSTRAINT acceptednameusage_pkey PRIMARY KEY (idacceptednameusage);


--
-- Name: accuralmethods_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY accrualmethod
    ADD CONSTRAINT accuralmethods_pkey PRIMARY KEY (idaccrualmethod);


--
-- Name: accuralperiodicities_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY accrualperiodicity
    ADD CONSTRAINT accuralperiodicities_pkey PRIMARY KEY (idaccrualperiodicity);


--
-- Name: accuralpolicies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY accrualpolicy
    ADD CONSTRAINT accuralpolicies_pkey PRIMARY KEY (idaccrualpolicy);


--
-- Name: annualcycle_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY annualcycle
    ADD CONSTRAINT annualcycle_pkey PRIMARY KEY (idannualcycle);


--
-- Name: associatedmedia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY associatedmedia
    ADD CONSTRAINT associatedmedia_pkey PRIMARY KEY (idmedia, idoccurrenceelements);


--
-- Name: associatedoccurrence_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY associatedoccurrence
    ADD CONSTRAINT associatedoccurrence_pkey PRIMARY KEY (idoccurrenceelements, idassociatedoccurrence);


--
-- Name: associatedoccurrencecuratorial_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY associatedoccurrencecuratorial
    ADD CONSTRAINT associatedoccurrencecuratorial_pkey PRIMARY KEY (idcuratorialelements, idoccurrenceelements);


--
-- Name: associatedsequecesoccurrence_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY occurrenceassociatedsequence
    ADD CONSTRAINT associatedsequecesoccurrence_pkey PRIMARY KEY (idoccurrenceelement, idassociatedsequence);


--
-- Name: associatedsequence_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY associatedsequence
    ADD CONSTRAINT associatedsequence_pkey PRIMARY KEY (idassociatedsequence);


--
-- Name: associatedsequencescuratorial_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY curatorialassociatedsequence
    ADD CONSTRAINT associatedsequencescuratorial_pkey PRIMARY KEY (idassociatedsequence, idcuratorialelement);


--
-- Name: associatedtaxa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY associatedtaxa
    ADD CONSTRAINT associatedtaxa_pkey PRIMARY KEY (idoccurrenceelements, idtaxonomicelements);


--
-- Name: audiences_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY audience
    ADD CONSTRAINT audiences_pkey PRIMARY KEY (idaudience);


--
-- Name: basisofrecords_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY basisofrecord
    ADD CONSTRAINT basisofrecords_pkey PRIMARY KEY (idbasisofrecord);


--
-- Name: behavior_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY behavior
    ADD CONSTRAINT behavior_pkey PRIMARY KEY (idbehavior);


--
-- Name: biome_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY biome
    ADD CONSTRAINT biome_pkey PRIMARY KEY (idbiome);


--
-- Name: canonicalauthorship_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY canonicalauthorship
    ADD CONSTRAINT canonicalauthorship_pkey PRIMARY KEY (idcanonicalauthorship);


--
-- Name: canonicalnames_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY canonicalname
    ADD CONSTRAINT canonicalnames_pkey PRIMARY KEY (idcanonicalname);


--
-- Name: capturedevice_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY capturedevice
    ADD CONSTRAINT capturedevice_pkey PRIMARY KEY (idcapturedevice);


--
-- Name: categorymedia_categorymedia_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY categorymedia
    ADD CONSTRAINT categorymedia_categorymedia_key UNIQUE (categorymedia);


--
-- Name: categorymedia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY categorymedia
    ADD CONSTRAINT categorymedia_pkey PRIMARY KEY (idcategorymedia);


--
-- Name: categoryreferences_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY categoryreference
    ADD CONSTRAINT categoryreferences_pkey PRIMARY KEY (idcategoryreference);


--
-- Name: classes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY class
    ADD CONSTRAINT classes_pkey PRIMARY KEY (idclass);


--
-- Name: collectioncodes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY collectioncode
    ADD CONSTRAINT collectioncodes_pkey PRIMARY KEY (idcollectioncode);


--
-- Name: collector_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY collector
    ADD CONSTRAINT collector_pkey PRIMARY KEY (idcollector);


--
-- Name: colorpantrap_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY colorpantrap
    ADD CONSTRAINT colorpantrap_pkey PRIMARY KEY (idcolorpantrap);


--
-- Name: commonnames_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY commonname
    ADD CONSTRAINT commonnames_pkey PRIMARY KEY (idcommonname);


--
-- Name: continents_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY continent
    ADD CONSTRAINT continents_pkey PRIMARY KEY (idcontinent);


--
-- Name: contributors_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY contributor
    ADD CONSTRAINT contributors_pkey PRIMARY KEY (idcontributor);


--
-- Name: counties_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY county
    ADD CONSTRAINT counties_pkey PRIMARY KEY (idcounty);


--
-- Name: countries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY country
    ADD CONSTRAINT countries_pkey PRIMARY KEY (idcountry);


--
-- Name: creatormedia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mediacreator
    ADD CONSTRAINT creatormedia_pkey PRIMARY KEY (idcreator, idmedia);


--
-- Name: creators_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY creator
    ADD CONSTRAINT creators_pkey PRIMARY KEY (idcreator);


--
-- Name: cultivar_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cultivar
    ADD CONSTRAINT cultivar_pkey PRIMARY KEY (idcultivar);


--
-- Name: culture_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY culture
    ADD CONSTRAINT culture_pkey PRIMARY KEY (idculture);


--
-- Name: curatorialelements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY curatorialelement
    ADD CONSTRAINT curatorialelements_pkey PRIMARY KEY (idcuratorialelement);


--
-- Name: dataset_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY dataset
    ADD CONSTRAINT dataset_pkey PRIMARY KEY (iddataset);


--
-- Name: deficit_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_pkey PRIMARY KEY (iddeficit);


--
-- Name: denomination_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY denomination
    ADD CONSTRAINT denomination_pkey PRIMARY KEY (iddenomination);


--
-- Name: digitizer_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY digitizer
    ADD CONSTRAINT digitizer_pkey PRIMARY KEY (iddigitizer);


--
-- Name: diseases_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY disease
    ADD CONSTRAINT diseases_pkey PRIMARY KEY (iddisease);


--
-- Name: dispersals_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY dispersal
    ADD CONSTRAINT dispersals_pkey PRIMARY KEY (iddispersal);


--
-- Name: disposition_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY disposition
    ADD CONSTRAINT disposition_pkey PRIMARY KEY (iddisposition);


--
-- Name: dynamicproperties_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY attributes
    ADD CONSTRAINT dynamicproperties_pkey PRIMARY KEY (idattributes);


--
-- Name: dynamicproperties_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY dynamicproperty
    ADD CONSTRAINT dynamicproperties_pkey1 PRIMARY KEY (iddynamicproperty);


--
-- Name: establishmentmeanss_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY establishmentmean
    ADD CONSTRAINT establishmentmeanss_pkey PRIMARY KEY (idestablishmentmean);


--
-- Name: eventelements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY eventelement
    ADD CONSTRAINT eventelements_pkey PRIMARY KEY (ideventelement);


--
-- Name: families_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY family
    ADD CONSTRAINT families_pkey PRIMARY KEY (idfamily);


--
-- Name: fileformats_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY fileformat
    ADD CONSTRAINT fileformats_pkey PRIMARY KEY (idfileformat);


--
-- Name: files_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY file
    ADD CONSTRAINT files_pkey PRIMARY KEY (idfile);


--
-- Name: focuscrop_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY focuscrop
    ADD CONSTRAINT focuscrop_pkey PRIMARY KEY (idfocuscrop);


--
-- Name: formatmedia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY formatmedia
    ADD CONSTRAINT formatmedia_pkey PRIMARY KEY (idformatmedia);


--
-- Name: genus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY genus
    ADD CONSTRAINT genus_pkey PRIMARY KEY (idgenus);


--
-- Name: geometry_columns_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY geometry_columns
    ADD CONSTRAINT geometry_columns_pk PRIMARY KEY (f_table_catalog, f_table_schema, f_table_name, f_geometry_column);


--
-- Name: georeferdby_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY localitygeoreferencedby
    ADD CONSTRAINT georeferdby_pkey PRIMARY KEY (idgeoreferencedby, idlocalityelement);


--
-- Name: georeferedby_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY georeferencedby
    ADD CONSTRAINT georeferedby_pkey PRIMARY KEY (idgeoreferencedby);


--
-- Name: georeferencesources_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY georeferencesource
    ADD CONSTRAINT georeferencesources_pkey PRIMARY KEY (idgeoreferencesource);


--
-- Name: georeferencesourcesgeospatial_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY geospatialgeoreferencesource
    ADD CONSTRAINT georeferencesourcesgeospatial_pkey PRIMARY KEY (idgeoreferencesource, idgeospatialelement);


--
-- Name: georeferencesourceslocality_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY localitygeoreferencesource
    ADD CONSTRAINT georeferencesourceslocality_pkey PRIMARY KEY (idgeoreferencesource, idlocalityelement);


--
-- Name: georeferenceverificationstatus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY georeferenceverificationstatus
    ADD CONSTRAINT georeferenceverificationstatus_pkey PRIMARY KEY (idgeoreferenceverificationstatus);


--
-- Name: geospatialelements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY geospatialelement
    ADD CONSTRAINT geospatialelements_pkey PRIMARY KEY (idgeospatialelement);


--
-- Name: groupdynamicproperties_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY groupattributes
    ADD CONSTRAINT groupdynamicproperties_pkey PRIMARY KEY ("idGroup", "idAttribute");


--
-- Name: grouppages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grouppages
    ADD CONSTRAINT grouppages_pkey PRIMARY KEY ("idGroup", "idPage");


--
-- Name: groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY ("idGroup");


--
-- Name: habitats_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY habitat
    ADD CONSTRAINT habitats_pkey PRIMARY KEY (idhabitat);


--
-- Name: id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY log_dq_fields
    ADD CONSTRAINT id PRIMARY KEY (id);


--
-- Name: id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY log_dq_deleted_items
    ADD CONSTRAINT id_pk PRIMARY KEY (id);


--
-- Name: idco; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY commonnamefocalcrop
    ADD CONSTRAINT idco PRIMARY KEY (idcommonnamefocalcrop);


--
-- Name: identificationelements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY identificationelement
    ADD CONSTRAINT identificationelements_pkey PRIMARY KEY (ididentificationelement);


--
-- Name: identificationkey_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY identificationkey
    ADD CONSTRAINT identificationkey_pkey PRIMARY KEY (idspecies, idreferenceelement);


--
-- Name: identificationqualifiers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY identificationqualifier
    ADD CONSTRAINT identificationqualifiers_pkey PRIMARY KEY (ididentificationqualifier);


--
-- Name: identifiedby_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY identifiedby
    ADD CONSTRAINT identifiedby_pkey PRIMARY KEY (ididentifiedby);


--
-- Name: identifiedbycuratorial_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY curatorialidentifiedby
    ADD CONSTRAINT identifiedbycuratorial_pkey PRIMARY KEY (idcuratorialelement, ididentifiedby);


--
-- Name: identifiedbyidentification_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY identificationidentifiedby
    ADD CONSTRAINT identifiedbyidentification_pkey PRIMARY KEY (ididentifiedby, ididentificationelement);


--
-- Name: individual_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY individual
    ADD CONSTRAINT individual_pkey PRIMARY KEY (idindividual);


--
-- Name: individualrel_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY occurrenceindividual
    ADD CONSTRAINT individualrel_pkey PRIMARY KEY (idindividual, idoccurrenceelement);


--
-- Name: infraspecificepithets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY infraspecificepithet
    ADD CONSTRAINT infraspecificepithets_pkey PRIMARY KEY (idinfraspecificepithet);


--
-- Name: institutioncodes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY institutioncode
    ADD CONSTRAINT institutioncodes_pkey PRIMARY KEY (idinstitutioncode);


--
-- Name: instructionalmethods_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY instructionalmethod
    ADD CONSTRAINT instructionalmethods_pkey PRIMARY KEY (idinstructionalmethod);


--
-- Name: interactionelements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY interaction
    ADD CONSTRAINT interactionelements_pkey PRIMARY KEY (idinteraction);


--
-- Name: interactiontypes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY interactiontype
    ADD CONSTRAINT interactiontypes_pkey PRIMARY KEY (idinteractiontype);


--
-- Name: islandgroups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY islandgroup
    ADD CONSTRAINT islandgroups_pkey PRIMARY KEY (idislandgroup);


--
-- Name: islands_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY island
    ADD CONSTRAINT islands_pkey PRIMARY KEY (idisland);


--
-- Name: keyword_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY keyword
    ADD CONSTRAINT keyword_pkey PRIMARY KEY (idkeyword);


--
-- Name: kingdoms_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY kingdom
    ADD CONSTRAINT kingdoms_pkey PRIMARY KEY (idkingdom);


--
-- Name: languages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY language
    ADD CONSTRAINT languages_pkey PRIMARY KEY (idlanguage);


--
-- Name: licenses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY license
    ADD CONSTRAINT licenses_pkey PRIMARY KEY (idlicense);


--
-- Name: lifecycles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY lifecycle
    ADD CONSTRAINT lifecycles_pkey PRIMARY KEY (idlifecycle);


--
-- Name: lifeexpectancies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY lifeexpectancy
    ADD CONSTRAINT lifeexpectancies_pkey PRIMARY KEY (idlifeexpectancy);


--
-- Name: lifestages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY lifestage
    ADD CONSTRAINT lifestages_pkey PRIMARY KEY (idlifestage);


--
-- Name: localities_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY locality
    ADD CONSTRAINT localities_pkey PRIMARY KEY (idlocality);


--
-- Name: localityelements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT localityelements_pkey PRIMARY KEY (idlocalityelement);


--
-- Name: log_dq_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY log_dq
    ADD CONSTRAINT log_dq_pk PRIMARY KEY (id);


--
-- Name: log_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY log
    ADD CONSTRAINT log_pkey PRIMARY KEY (idlog);


--
-- Name: mainplantspeciesinhedge_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mainplantspeciesinhedge
    ADD CONSTRAINT mainplantspeciesinhedge_pkey PRIMARY KEY (idmainplantspeciesinhedge);


--
-- Name: media_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY media
    ADD CONSTRAINT media_pkey PRIMARY KEY (idmedia);


--
-- Name: mediaspecie_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY specimenmedia
    ADD CONSTRAINT mediaspecie_pkey PRIMARY KEY (idspecimen, idmedia);


--
-- Name: metadataprovider_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY metadataprovider
    ADD CONSTRAINT metadataprovider_pkey PRIMARY KEY (idmetadataprovider);


--
-- Name: migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY migration
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (idmigration);


--
-- Name: monitoring_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT monitoring_pkey PRIMARY KEY (idmonitoring);


--
-- Name: morphospecies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY morphospecies
    ADD CONSTRAINT morphospecies_pkey PRIMARY KEY (idmorphospecies);


--
-- Name: municipality_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY municipality
    ADD CONSTRAINT municipality_pkey PRIMARY KEY (idmunicipality);


--
-- Name: nameaccordingto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY nameaccordingto
    ADD CONSTRAINT nameaccordingto_pkey PRIMARY KEY (idnameaccordingto);


--
-- Name: namepublishedin_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY namepublishedin
    ADD CONSTRAINT namepublishedin_pkey PRIMARY KEY (idnamepublishedin);


--
-- Name: nomenclaturalcodes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY nomenclaturalcode
    ADD CONSTRAINT nomenclaturalcodes_pkey PRIMARY KEY (idnomenclaturalcode);


--
-- Name: observer_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY observer
    ADD CONSTRAINT observer_pkey PRIMARY KEY (idobserver);


--
-- Name: occurrence_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT occurrence_pkey PRIMARY KEY (idoccurrenceelement);


--
-- Name: orders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "order"
    ADD CONSTRAINT orders_pkey PRIMARY KEY (idorder);


--
-- Name: originalnameusage_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY originalnameusage
    ADD CONSTRAINT originalnameusage_pkey PRIMARY KEY (idoriginalnameusage);


--
-- Name: originseeds_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY originseeds
    ADD CONSTRAINT originseeds_pkey PRIMARY KEY (idoriginseeds);


--
-- Name: ownerinstitution_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ownerinstitution
    ADD CONSTRAINT ownerinstitution_pkey PRIMARY KEY (idownerinstitution);


--
-- Name: pages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY page
    ADD CONSTRAINT pages_pkey PRIMARY KEY (idpage);


--
-- Name: parentnameusage_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY parentnameusage
    ADD CONSTRAINT parentnameusage_pkey PRIMARY KEY (idparentnameusage);


--
-- Name: phylums_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY phylum
    ADD CONSTRAINT phylums_pkey PRIMARY KEY (idphylum);


--
-- Name: pk_preparation; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY preparation
    ADD CONSTRAINT pk_preparation PRIMARY KEY (idpreparation);


--
-- Name: pk_preparationrel; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY curatorialpreparation
    ADD CONSTRAINT pk_preparationrel PRIMARY KEY (idpreparation, idcuratorialelement);


--
-- Name: plantcommonname_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY plantcommonname
    ADD CONSTRAINT plantcommonname_pkey PRIMARY KEY (idplantcommonname);


--
-- Name: plantfamily_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY plantfamily
    ADD CONSTRAINT plantfamily_pkey PRIMARY KEY (idplantfamily);


--
-- Name: plantspecies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY plantspecies
    ADD CONSTRAINT plantspecies_pkey PRIMARY KEY (idplantspecies);


--
-- Name: pollinatorcommonname_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pollinatorcommonname
    ADD CONSTRAINT pollinatorcommonname_pkey PRIMARY KEY (idpollinatorcommonname);


--
-- Name: pollinatorfamily_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pollinatorfamily
    ADD CONSTRAINT pollinatorfamily_pkey PRIMARY KEY (idpollinatorfamily);


--
-- Name: pollinatorspecies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pollinatorspecies
    ADD CONSTRAINT pollinatorspecies_pkey PRIMARY KEY (idpollinatorspecies);


--
-- Name: predominantbiome_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY predominantbiome
    ADD CONSTRAINT predominantbiome_pkey PRIMARY KEY (idpredominantbiome);


--
-- Name: preparationsoccurrence_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY occurrencepreparation
    ADD CONSTRAINT preparationsoccurrence_pkey PRIMARY KEY (idoccurrenceelement, idpreparation);


--
-- Name: previousidentifications_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY previousidentification
    ADD CONSTRAINT previousidentifications_pkey PRIMARY KEY (ididentificationelement, idoccurrenceelement);


--
-- Name: process_execution_ok; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY process_specimens_execution
    ADD CONSTRAINT process_execution_ok PRIMARY KEY (id);


--
-- Name: process_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY process_log_dq
    ADD CONSTRAINT process_pk PRIMARY KEY (id);


--
-- Name: process_taxons_execution_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY process_taxons_execution
    ADD CONSTRAINT process_taxons_execution_pk PRIMARY KEY (id);


--
-- Name: productionvariety_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY productionvariety
    ADD CONSTRAINT productionvariety_pkey PRIMARY KEY (idproductionvariety);


--
-- Name: provider_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY provider
    ADD CONSTRAINT provider_pkey PRIMARY KEY (idprovider);


--
-- Name: publishers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY publisher
    ADD CONSTRAINT publishers_pkey PRIMARY KEY (idpublisher);


--
-- Name: recordedby_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY collectedby
    ADD CONSTRAINT recordedby_pkey PRIMARY KEY (idcollectedby);


--
-- Name: recordedby_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY recordedby
    ADD CONSTRAINT recordedby_pkey1 PRIMARY KEY (idrecordedby);


--
-- Name: recordedbycuratorial_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY curatorialrecordedby
    ADD CONSTRAINT recordedbycuratorial_pkey PRIMARY KEY (idrecordedby, idcuratorialelement);


--
-- Name: recordedbyoccurrence_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY occurrencerecordedby
    ADD CONSTRAINT recordedbyoccurrence_pkey PRIMARY KEY (idrecordedby, idoccurrenceelement);


--
-- Name: recordleveldynamicproperty_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY recordleveldynamicproperty
    ADD CONSTRAINT recordleveldynamicproperty_pkey PRIMARY KEY (idrecordlevelelement, iddynamicproperty);


--
-- Name: recordlevelelements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT recordlevelelements_pkey PRIMARY KEY (idrecordlevelelement);


--
-- Name: referenceafiliation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referenceafiliation
    ADD CONSTRAINT referenceafiliation_pkey PRIMARY KEY (idreferenceelement, idafiliation);


--
-- Name: referencebiome_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referencebiome
    ADD CONSTRAINT referencebiome_pkey PRIMARY KEY (idreferenceelement, idbiome);


--
-- Name: referencecreator_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referencecreator
    ADD CONSTRAINT referencecreator_pkey PRIMARY KEY (idcreator, idreferenceelement);


--
-- Name: referencekeyword_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referencekeyword
    ADD CONSTRAINT referencekeyword_pkey PRIMARY KEY (idreferenceelement, idkeyword);


--
-- Name: referenceoccurrence_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY associatedreferences
    ADD CONSTRAINT referenceoccurrence_pkey PRIMARY KEY (idreferenceselements, idoccurrenceelements);


--
-- Name: referenceplantcommonname_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referenceplantcommonname
    ADD CONSTRAINT referenceplantcommonname_pkey PRIMARY KEY (idplantcommonname, idreferenceelement);


--
-- Name: referenceplantfamily_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referenceplantfamily
    ADD CONSTRAINT referenceplantfamily_pkey PRIMARY KEY (idreferenceelement, idplantfamily);


--
-- Name: referenceplantspecies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referenceplantspecies
    ADD CONSTRAINT referenceplantspecies_pkey PRIMARY KEY (idplantspecies, idreferenceelement);


--
-- Name: referencepollinatorcommonname_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referencepollinatorcommonname
    ADD CONSTRAINT referencepollinatorcommonname_pkey PRIMARY KEY (idreferenceelement, idpollinatorcommonname);


--
-- Name: referencepollinatorfamily_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referencepollinatorfamily
    ADD CONSTRAINT referencepollinatorfamily_pkey PRIMARY KEY (idreferenceelement, idpollinatorfamily);


--
-- Name: referencepollinatorspecies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referencepollinatorspecies
    ADD CONSTRAINT referencepollinatorspecies_pkey PRIMARY KEY (idreferenceelement, idpollinatorspecies);


--
-- Name: referenceselements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referenceelement
    ADD CONSTRAINT referenceselements_pkey PRIMARY KEY (idreferenceelement);


--
-- Name: referencesidentification_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referencesidentification
    ADD CONSTRAINT referencesidentification_pkey PRIMARY KEY (ididentificationelements, idreferenceselements);


--
-- Name: referencesspecie_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referencesspecie
    ADD CONSTRAINT referencesspecie_pkey PRIMARY KEY (idreferenceselements, idspecieselements);


--
-- Name: referencestaxonomic_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY referencestaxonomic
    ADD CONSTRAINT referencestaxonomic_pkey PRIMARY KEY (idtaxonomicelements, idreferenceselements);


--
-- Name: relatedname_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY relatedname
    ADD CONSTRAINT relatedname_pkey PRIMARY KEY (idrelatedname);


--
-- Name: reproductions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY reproduction
    ADD CONSTRAINT reproductions_pkey PRIMARY KEY (idreproduction);


--
-- Name: reproductivecondition_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY reproductivecondition
    ADD CONSTRAINT reproductivecondition_pkey PRIMARY KEY (idreproductivecondition);


--
-- Name: samplingprotocols_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY samplingprotocol
    ADD CONSTRAINT samplingprotocols_pkey PRIMARY KEY (idsamplingprotocol);


--
-- Name: scientificnameauthorships_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY scientificnameauthorship
    ADD CONSTRAINT scientificnameauthorships_pkey PRIMARY KEY (idscientificnameauthorship);


--
-- Name: scientificnames_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY scientificname
    ADD CONSTRAINT scientificnames_pkey PRIMARY KEY (idscientificname);


--
-- Name: sexes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sex
    ADD CONSTRAINT sexes_pkey PRIMARY KEY (idsex);


--
-- Name: site__pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY site_
    ADD CONSTRAINT site__pkey PRIMARY KEY (idsite_);


--
-- Name: soilpreparation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY soilpreparation
    ADD CONSTRAINT soilpreparation_pkey PRIMARY KEY (idsoilpreparation);


--
-- Name: soiltype_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY soiltype
    ADD CONSTRAINT soiltype_pkey PRIMARY KEY (idsoiltype);


--
-- Name: source_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY source
    ADD CONSTRAINT source_pkey PRIMARY KEY (idsource);


--
-- Name: spatial_ref_sys_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY spatial_ref_sys
    ADD CONSTRAINT spatial_ref_sys_pkey PRIMARY KEY (srid);


--
-- Name: specie_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY species
    ADD CONSTRAINT specie_pkey PRIMARY KEY (idspecies);


--
-- Name: speciescontributor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speciescontributor
    ADD CONSTRAINT speciescontributor_pkey PRIMARY KEY (idspecies, idcontributor);


--
-- Name: speciescreator_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speciescreator
    ADD CONSTRAINT speciescreator_pkey PRIMARY KEY (idspecies, idcreator);


--
-- Name: speciesidkey_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speciesidkey
    ADD CONSTRAINT speciesidkey_pkey PRIMARY KEY (idspecies, idreferenceelement);


--
-- Name: speciesmedia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speciesmedia
    ADD CONSTRAINT speciesmedia_pkey PRIMARY KEY (idspecies, idmedia);


--
-- Name: speciesname_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speciesname
    ADD CONSTRAINT speciesname_pkey PRIMARY KEY (idspeciesname);


--
-- Name: speciespaper_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speciespaper
    ADD CONSTRAINT speciespaper_pkey PRIMARY KEY (idspecies, idreferenceelement);


--
-- Name: speciespublicationreference_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speciespublicationreference
    ADD CONSTRAINT speciespublicationreference_pkey PRIMARY KEY (idspecies, idreferenceelement);


--
-- Name: speciesreference_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speciesreference
    ADD CONSTRAINT speciesreference_pkey PRIMARY KEY (idspecies, idreferenceelement);


--
-- Name: speciesrelatedname_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speciesrelatedname
    ADD CONSTRAINT speciesrelatedname_pkey PRIMARY KEY (idspecies, idrelatedname);


--
-- Name: speciessynonym_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speciessynonym
    ADD CONSTRAINT speciessynonym_pkey PRIMARY KEY (idspecies, idsynonym);


--
-- Name: specificepithets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY specificepithet
    ADD CONSTRAINT specificepithets_pkey PRIMARY KEY (idspecificepithet);


--
-- Name: specimenelement_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT specimenelement_pkey PRIMARY KEY (idspecimen);


--
-- Name: specimenreference_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY specimenreference
    ADD CONSTRAINT specimenreference_pkey PRIMARY KEY (idspecimen, idreferenceelement);


--
-- Name: stateprovinces_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY stateprovince
    ADD CONSTRAINT stateprovinces_pkey PRIMARY KEY (idstateprovince);


--
-- Name: subcategorymedia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subcategorymedia
    ADD CONSTRAINT subcategorymedia_pkey PRIMARY KEY (idsubcategorymedia);


--
-- Name: subcategorymedia_subcategorymedia_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subcategorymedia
    ADD CONSTRAINT subcategorymedia_subcategorymedia_key UNIQUE (subcategorymedia);


--
-- Name: subcategoryreferences_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subcategoryreference
    ADD CONSTRAINT subcategoryreferences_pkey PRIMARY KEY (idsubcategoryreference);


--
-- Name: subgenus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subgenus
    ADD CONSTRAINT subgenus_pkey PRIMARY KEY (idsubgenus);


--
-- Name: subjectcategory_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subjectcategory
    ADD CONSTRAINT subjectcategory_pkey PRIMARY KEY (idsubjectcategory);


--
-- Name: subjectcategorymedia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mediasubjectcategory
    ADD CONSTRAINT subjectcategorymedia_pkey PRIMARY KEY (idsubjectcategory, idmedia);


--
-- Name: subspecies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subspecies
    ADD CONSTRAINT subspecies_pkey PRIMARY KEY (idsubspecies);


--
-- Name: subtribe_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subtribe
    ADD CONSTRAINT subtribe_pkey PRIMARY KEY (idsubtribe);


--
-- Name: subtype_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subtype
    ADD CONSTRAINT subtype_pkey PRIMARY KEY (idsubtype);


--
-- Name: subtypereferences_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY subtypereference
    ADD CONSTRAINT subtypereferences_pkey PRIMARY KEY (idsubtypereference);


--
-- Name: supporttype_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY supporttype
    ADD CONSTRAINT supporttype_pkey PRIMARY KEY (idsupporttype);


--
-- Name: surroundingsculture_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY surroundingsculture
    ADD CONSTRAINT surroundingsculture_pkey PRIMARY KEY (idsurroundingsculture);


--
-- Name: surroundingsvegetation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY surroundingsvegetation
    ADD CONSTRAINT surroundingsvegetation_pkey PRIMARY KEY (idsurroundingsvegetation);


--
-- Name: synonym_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY synonym
    ADD CONSTRAINT synonym_pkey PRIMARY KEY (idsynonym);


--
-- Name: tag_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tag
    ADD CONSTRAINT tag_pkey PRIMARY KEY (idtag);


--
-- Name: tag_tag_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tag
    ADD CONSTRAINT tag_tag_key UNIQUE (tag);


--
-- Name: tagmedia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mediatag
    ADD CONSTRAINT tagmedia_pkey PRIMARY KEY (idtag, idmedia);


--
-- Name: taxonconcept_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY taxonconcept
    ADD CONSTRAINT taxonconcept_pkey PRIMARY KEY (idtaxonconcept);


--
-- Name: taxonomicelementcommonname_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY taxonomicelementcommonname
    ADD CONSTRAINT taxonomicelementcommonname_pkey PRIMARY KEY (idtaxonomicelement, idcommonname);


--
-- Name: taxonomicelementrelatedname_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY taxonomicelementrelatedname
    ADD CONSTRAINT taxonomicelementrelatedname_pkey PRIMARY KEY (idrelatedname, idtaxonomicelement);


--
-- Name: taxonomicelements_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_pkey PRIMARY KEY (idtaxonomicelement);


--
-- Name: taxonomicelementsynonym_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY taxonomicelementsynonym
    ADD CONSTRAINT taxonomicelementsynonym_pkey PRIMARY KEY (idsynonym, idtaxonomicelement);


--
-- Name: taxonomicstatus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY taxonomicstatus
    ADD CONSTRAINT taxonomicstatus_pkey PRIMARY KEY (idtaxonomicstatus);


--
-- Name: taxonranks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY taxonrank
    ADD CONSTRAINT taxonranks_pkey PRIMARY KEY (idtaxonrank);


--
-- Name: technicalcollection_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY technicalcollection
    ADD CONSTRAINT technicalcollection_pkey PRIMARY KEY (idtechnicalcollection);


--
-- Name: topograficalsituation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY topograficalsituation
    ADD CONSTRAINT topograficalsituation_pkey PRIMARY KEY (idtopograficalsituation);


--
-- Name: treatment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY treatment
    ADD CONSTRAINT treatment_pkey PRIMARY KEY (idtreatment);


--
-- Name: tribe_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tribe
    ADD CONSTRAINT tribe_pkey PRIMARY KEY (idtribe);


--
-- Name: type_log_dq_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY type_log_dq
    ADD CONSTRAINT type_log_dq_pk PRIMARY KEY (id);


--
-- Name: typeholding_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY typeholding
    ADD CONSTRAINT typeholding_pkey PRIMARY KEY (idtypeholding);


--
-- Name: typemedia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY typemedia
    ADD CONSTRAINT typemedia_pkey PRIMARY KEY (idtypemedia);


--
-- Name: typeplanting_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY typeplanting
    ADD CONSTRAINT typeplanting_pkey PRIMARY KEY (idtypeplanting);


--
-- Name: typereferences_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY typereference
    ADD CONSTRAINT typereferences_pkey PRIMARY KEY (idtypereference);


--
-- Name: types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY type
    ADD CONSTRAINT types_pkey PRIMARY KEY (idtype);


--
-- Name: typestand_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY typestand
    ADD CONSTRAINT typestand_pkey PRIMARY KEY (idtypestand);


--
-- Name: typestatus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY typestatus
    ADD CONSTRAINT typestatus_pkey PRIMARY KEY (idtypestatus);


--
-- Name: typestatuscuratorial_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY curatorialtypestatus
    ADD CONSTRAINT typestatuscuratorial_pkey PRIMARY KEY (idcuratorialelement, idtypestatus);


--
-- Name: typestatusidentification_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY identificationtypestatus
    ADD CONSTRAINT typestatusidentification_pkey PRIMARY KEY (ididentificationelement, idtypestatus);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY ("idUser");


--
-- Name: users_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- Name: validacao_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY validacao
    ADD CONSTRAINT validacao_pkey PRIMARY KEY (idvalidacao);


--
-- Name: waterbodies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY waterbody
    ADD CONSTRAINT waterbodies_pkey PRIMARY KEY (idwaterbody);


--
-- Name: weathercondition_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY weathercondition
    ADD CONSTRAINT weathercondition_pkey PRIMARY KEY (idweathercondition);


--
-- Name: 222; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "222" ON interaction USING btree (idspecimen2);


--
-- Name: Title; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "Title" ON referenceelement USING btree (title);


--
-- Name: a; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX a ON occurrenceassociatedsequence USING btree (idassociatedsequence);


--
-- Name: aa; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX aa ON occurrencepreparation USING btree (idpreparation);


--
-- Name: aaa; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX aaa ON identificationidentifiedby USING btree (ididentificationelement);


--
-- Name: b; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX b ON occurrenceindividual USING btree (idoccurrenceelement);


--
-- Name: bb; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX bb ON occurrencerecordedby USING btree (idoccurrenceelement);


--
-- Name: ccxc; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX ccxc ON interaction USING btree (idspecimen1);


--
-- Name: fki_; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_ ON recordlevelelement USING btree (idtype);


--
-- Name: fki_curatoriaassocia; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_curatoriaassocia ON associatedoccurrence USING btree (idoccurrenceelements);


--
-- Name: fki_curatprep; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_curatprep ON curatorialpreparation USING btree (idcuratorialelement);


--
-- Name: fki_iddispo; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_iddispo ON curatorialelement USING btree (iddisposition);


--
-- Name: fki_idhabit; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_idhabit ON localityelement USING btree (idhabitat);


--
-- Name: fki_languages; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_languages ON recordlevelelement USING btree (idlanguage);


--
-- Name: fki_munic; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_munic ON localityelement USING btree (idmunicipality);


--
-- Name: fki_ownerinstitution; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_ownerinstitution ON recordlevelelement USING btree (idownerinstitution);


--
-- Name: fki_speciespaper; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_speciespaper ON speciespaper USING btree (idreferenceelement);


--
-- Name: fki_sppublic; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_sppublic ON speciespublicationreference USING btree (idreferenceelement);


--
-- Name: fki_ss; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_ss ON speciesreference USING btree (idreferenceelement);


--
-- Name: fki_subtribe; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_subtribe ON taxonomicelement USING btree (idsubtribe);


--
-- Name: fki_tribe; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_tribe ON taxonomicelement USING btree (idtribe);


--
-- Name: fki_users_log_dq_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_users_log_dq_fk ON log_dq USING btree (id_user);


--
-- Name: fki_users_process_log_dq_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_users_process_log_dq_fk ON log_dq USING btree (id_user);


--
-- Name: fki_wedf; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_wedf ON speciesidkey USING btree (idreferenceelement);


--
-- Name: fki_ww; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_ww ON speciesmedia USING btree (idmedia);


--
-- Name: groupdynamicproperties_fkidattribute; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX groupdynamicproperties_fkidattribute ON groupattributes USING btree ("idAttribute");


--
-- Name: groupdynamicproperties_fkidgroup; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX groupdynamicproperties_fkidgroup ON groupattributes USING btree ("idGroup");


--
-- Name: grouppages_fkidgroup; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX grouppages_fkidgroup ON grouppages USING btree ("idGroup");


--
-- Name: grouppages_fkidpage; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX grouppages_fkidpage ON grouppages USING btree ("idPage");


--
-- Name: identificationelements_fkididentificationqualifier; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX identificationelements_fkididentificationqualifier ON identificationelement USING btree (ididentificationqualifier);


--
-- Name: idx_subtypereference_lookup; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX idx_subtypereference_lookup ON subtypereference USING btree (subtypereference);


--
-- Name: interactionelements_fkidinteractiontype; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX interactionelements_fkidinteractiontype ON interaction USING btree (idinteractiontype);


--
-- Name: jvjhgf; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX jvjhgf ON recordleveldynamicproperty USING btree (iddynamicproperty);


--
-- Name: q; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX q ON identificationtypestatus USING btree (idtypestatus);


--
-- Name: recordlevelelements_fkidbasisofrecord; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX recordlevelelements_fkidbasisofrecord ON recordlevelelement USING btree (idbasisofrecord);


--
-- Name: recordlevelelements_fkidcollectioncode; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX recordlevelelements_fkidcollectioncode ON recordlevelelement USING btree (idcollectioncode);


--
-- Name: recordlevelelements_fkidinstitutioncode; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX recordlevelelements_fkidinstitutioncode ON recordlevelelement USING btree (idinstitutioncode);


--
-- Name: rrr; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX rrr ON localitygeoreferencesource USING btree (idlocalityelement);


--
-- Name: scn; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX scn ON taxonomicelement USING btree (idscientificname);


--
-- Name: scn_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX scn_index ON scientificname USING btree (scientificname);


--
-- Name: taxonomicelements_fkidclass; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX taxonomicelements_fkidclass ON taxonomicelement USING btree (idclass);


--
-- Name: taxonomicelements_fkidfamily; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX taxonomicelements_fkidfamily ON taxonomicelement USING btree (idfamily);


--
-- Name: taxonomicelements_fkidgenus; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX taxonomicelements_fkidgenus ON taxonomicelement USING btree (idgenus);


--
-- Name: taxonomicelements_fkidinfraspecificepithet; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX taxonomicelements_fkidinfraspecificepithet ON taxonomicelement USING btree (idinfraspecificepithet);


--
-- Name: taxonomicelements_fkidkingdom; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX taxonomicelements_fkidkingdom ON taxonomicelement USING btree (idkingdom);


--
-- Name: taxonomicelements_fkidnomenclaturalcode; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX taxonomicelements_fkidnomenclaturalcode ON taxonomicelement USING btree (idnomenclaturalcode);


--
-- Name: taxonomicelements_fkidorder; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX taxonomicelements_fkidorder ON taxonomicelement USING btree (idorder);


--
-- Name: taxonomicelements_fkidphylum; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX taxonomicelements_fkidphylum ON taxonomicelement USING btree (idphylum);


--
-- Name: taxonomicelements_fkidscientificname; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX taxonomicelements_fkidscientificname ON taxonomicelement USING btree (idscientificname);


--
-- Name: taxonomicelements_fkidscientificnameauthorship; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX taxonomicelements_fkidscientificnameauthorship ON taxonomicelement USING btree (idscientificnameauthorship);


--
-- Name: taxonomicelements_fkidspecificepithet; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX taxonomicelements_fkidspecificepithet ON taxonomicelement USING btree (idspecificepithet);


--
-- Name: taxonomicelements_fkidtaxonrank; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX taxonomicelements_fkidtaxonrank ON taxonomicelement USING btree (idtaxonrank);


--
-- Name: users_fkidgroup; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX users_fkidgroup ON users USING btree ("idGroup");


--
-- Name: ww; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX ww ON localitygeoreferencedby USING btree (idlocalityelement);


--
-- Name: associatedmedia_idoccurrenceelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedmedia
    ADD CONSTRAINT associatedmedia_idoccurrenceelements_fkey FOREIGN KEY (idoccurrenceelements) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: associatedoccurrence_idassociatedoccurrence_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedoccurrence
    ADD CONSTRAINT associatedoccurrence_idassociatedoccurrence_fkey FOREIGN KEY (idassociatedoccurrence) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: associatedoccurrence_idoccurrence_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedoccurrence
    ADD CONSTRAINT associatedoccurrence_idoccurrence_fkey FOREIGN KEY (idoccurrenceelements) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: associatedoccurrencecuratorial_idcuratorialelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedoccurrencecuratorial
    ADD CONSTRAINT associatedoccurrencecuratorial_idcuratorialelements_fkey FOREIGN KEY (idcuratorialelements) REFERENCES curatorialelement(idcuratorialelement);


--
-- Name: associatedoccurrencecuratorial_idoccurrenceelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedoccurrencecuratorial
    ADD CONSTRAINT associatedoccurrencecuratorial_idoccurrenceelements_fkey FOREIGN KEY (idoccurrenceelements) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: associatedsequencescuratorial_idassociatedsequences_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialassociatedsequence
    ADD CONSTRAINT associatedsequencescuratorial_idassociatedsequences_fkey FOREIGN KEY (idassociatedsequence) REFERENCES associatedsequence(idassociatedsequence);


--
-- Name: associatedsequencescuratorial_idcuratorialelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialassociatedsequence
    ADD CONSTRAINT associatedsequencescuratorial_idcuratorialelements_fkey FOREIGN KEY (idcuratorialelement) REFERENCES curatorialelement(idcuratorialelement);


--
-- Name: associatedtaxa_idoccurrence_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedtaxa
    ADD CONSTRAINT associatedtaxa_idoccurrence_fkey FOREIGN KEY (idoccurrenceelements) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: associatedtaxa_idtaxonomicelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedtaxa
    ADD CONSTRAINT associatedtaxa_idtaxonomicelements_fkey FOREIGN KEY (idtaxonomicelements) REFERENCES taxonomicelement(idtaxonomicelement);


--
-- Name: atr; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY groupattributes
    ADD CONSTRAINT atr FOREIGN KEY ("idAttribute") REFERENCES attributes(idattributes);


--
-- Name: canonicalnames_ibfk_idcanonicalauthorship; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY canonicalname
    ADD CONSTRAINT canonicalnames_ibfk_idcanonicalauthorship FOREIGN KEY (idcanonicalauthorship) REFERENCES canonicalauthorship(idcanonicalauthorship);


--
-- Name: creatormedia_idcreators_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mediacreator
    ADD CONSTRAINT creatormedia_idcreators_fkey FOREIGN KEY (idcreator) REFERENCES creator(idcreator);


--
-- Name: creatormedia_idmedia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mediacreator
    ADD CONSTRAINT creatormedia_idmedia_fkey FOREIGN KEY (idmedia) REFERENCES media(idmedia);


--
-- Name: curatprep; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialpreparation
    ADD CONSTRAINT curatprep FOREIGN KEY (idcuratorialelement) REFERENCES curatorialelement(idcuratorialelement);


--
-- Name: deficit_idcommonnamefocalcrop_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idcommonnamefocalcrop_fkey FOREIGN KEY (idcommonnamefocalcrop) REFERENCES commonnamefocalcrop(idcommonnamefocalcrop);


--
-- Name: deficit_idfocuscrop_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idfocuscrop_fkey FOREIGN KEY (idfocuscrop) REFERENCES focuscrop(idfocuscrop);


--
-- Name: deficit_idgeospatialelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idgeospatialelement_fkey FOREIGN KEY (idgeospatialelement) REFERENCES geospatialelement(idgeospatialelement);


--
-- Name: deficit_idlocalityelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idlocalityelement_fkey FOREIGN KEY (idlocalityelement) REFERENCES localityelement(idlocalityelement);


--
-- Name: deficit_idmainplantspeciesinhedge_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idmainplantspeciesinhedge_fkey FOREIGN KEY (idmainplantspeciesinhedge) REFERENCES mainplantspeciesinhedge(idmainplantspeciesinhedge);


--
-- Name: deficit_idobserver_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idobserver_fkey FOREIGN KEY (idobserver) REFERENCES observer(idobserver);


--
-- Name: deficit_idoriginseeds_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idoriginseeds_fkey FOREIGN KEY (idoriginseeds) REFERENCES originseeds(idoriginseeds);


--
-- Name: deficit_idproductionvariety_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idproductionvariety_fkey FOREIGN KEY (idproductionvariety) REFERENCES productionvariety(idproductionvariety);


--
-- Name: deficit_idscientificname_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idscientificname_fkey FOREIGN KEY (idscientificname) REFERENCES scientificname(idscientificname);


--
-- Name: deficit_idsoilpreparation_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idsoilpreparation_fkey FOREIGN KEY (idsoilpreparation) REFERENCES soilpreparation(idsoilpreparation);


--
-- Name: deficit_idsoiltype_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idsoiltype_fkey FOREIGN KEY (idsoiltype) REFERENCES soiltype(idsoiltype);


--
-- Name: deficit_idtopograficalsituation_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idtopograficalsituation_fkey FOREIGN KEY (idtopograficalsituation) REFERENCES topograficalsituation(idtopograficalsituation);


--
-- Name: deficit_idtreatment_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idtreatment_fkey FOREIGN KEY (idtreatment) REFERENCES treatment(idtreatment);


--
-- Name: deficit_idtypeholding_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idtypeholding_fkey FOREIGN KEY (idtypeholding) REFERENCES typeholding(idtypeholding);


--
-- Name: deficit_idtypeplanting_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idtypeplanting_fkey FOREIGN KEY (idtypeplanting) REFERENCES typeplanting(idtypeplanting);


--
-- Name: deficit_idtypestand_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idtypestand_fkey FOREIGN KEY (idtypestand) REFERENCES typestand(idtypestand);


--
-- Name: deficit_idweathercondition_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY deficit
    ADD CONSTRAINT deficit_idweathercondition_fkey FOREIGN KEY (idweathercondition) REFERENCES weathercondition(idweathercondition);


--
-- Name: di; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialidentifiedby
    ADD CONSTRAINT di FOREIGN KEY (ididentifiedby) REFERENCES identifiedby(ididentifiedby);


--
-- Name: eventelements_idhabitat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY eventelement
    ADD CONSTRAINT eventelements_idhabitat_fkey FOREIGN KEY (idhabitat) REFERENCES habitat(idhabitat);


--
-- Name: eventelements_idsamplingprotocol_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY eventelement
    ADD CONSTRAINT eventelements_idsamplingprotocol_fkey FOREIGN KEY (idsamplingprotocol) REFERENCES samplingprotocol(idsamplingprotocol);


--
-- Name: files_ibfk_idfiles; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceelement
    ADD CONSTRAINT files_ibfk_idfiles FOREIGN KEY (idfile) REFERENCES file(idfile);


--
-- Name: fk_acceptednameusage; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT fk_acceptednameusage FOREIGN KEY (idacceptednameusage) REFERENCES acceptednameusage(idacceptednameusage);


--
-- Name: fk_associatedoccurrence_idassociatedoccurrence; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedoccurrence
    ADD CONSTRAINT fk_associatedoccurrence_idassociatedoccurrence FOREIGN KEY (idassociatedoccurrence) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: fk_associatedoccurrence_idoccurrenceelements; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedoccurrence
    ADD CONSTRAINT fk_associatedoccurrence_idoccurrenceelements FOREIGN KEY (idoccurrenceelements) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: fk_associatedoccurrencecuratorial_idcuratorialelements; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedoccurrencecuratorial
    ADD CONSTRAINT fk_associatedoccurrencecuratorial_idcuratorialelements FOREIGN KEY (idcuratorialelements) REFERENCES curatorialelement(idcuratorialelement);


--
-- Name: fk_associatedoccurrencecuratorial_idoccurrenceelements; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedoccurrencecuratorial
    ADD CONSTRAINT fk_associatedoccurrencecuratorial_idoccurrenceelements FOREIGN KEY (idoccurrenceelements) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: fk_associatedtaxa_idoccurrenceelements; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedtaxa
    ADD CONSTRAINT fk_associatedtaxa_idoccurrenceelements FOREIGN KEY (idoccurrenceelements) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: fk_associatedtaxa_idtaxonomicelements; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedtaxa
    ADD CONSTRAINT fk_associatedtaxa_idtaxonomicelements FOREIGN KEY (idtaxonomicelements) REFERENCES taxonomicelement(idtaxonomicelement);


--
-- Name: fk_curatorialelement_iddisposition; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialelement
    ADD CONSTRAINT fk_curatorialelement_iddisposition FOREIGN KEY (iddisposition) REFERENCES disposition(iddisposition);


--
-- Name: fk_eventelement_idhabitat; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY eventelement
    ADD CONSTRAINT fk_eventelement_idhabitat FOREIGN KEY (idhabitat) REFERENCES habitat(idhabitat);


--
-- Name: fk_eventelement_idsamplingprotocol; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY eventelement
    ADD CONSTRAINT fk_eventelement_idsamplingprotocol FOREIGN KEY (idsamplingprotocol) REFERENCES samplingprotocol(idsamplingprotocol);


--
-- Name: fk_geospatialelement_idgeoreferenceverificationstatus; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY geospatialelement
    ADD CONSTRAINT fk_geospatialelement_idgeoreferenceverificationstatus FOREIGN KEY (idgeoreferenceverificationstatus) REFERENCES georeferenceverificationstatus(idgeoreferenceverificationstatus);


--
-- Name: fk_identificationelement_ididentificationqualifier; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY identificationelement
    ADD CONSTRAINT fk_identificationelement_ididentificationqualifier FOREIGN KEY (ididentificationqualifier) REFERENCES identificationqualifier(ididentificationqualifier);


--
-- Name: fk_localityelement_idcontinent; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT fk_localityelement_idcontinent FOREIGN KEY (idcontinent) REFERENCES continent(idcontinent);


--
-- Name: fk_localityelement_idcountry; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT fk_localityelement_idcountry FOREIGN KEY (idcountry) REFERENCES country(idcountry);


--
-- Name: fk_localityelement_idcounty; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT fk_localityelement_idcounty FOREIGN KEY (idcounty) REFERENCES county(idcounty);


--
-- Name: fk_localityelement_idgeoreferenceverificationstatus; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT fk_localityelement_idgeoreferenceverificationstatus FOREIGN KEY (idgeoreferenceverificationstatus) REFERENCES georeferenceverificationstatus(idgeoreferenceverificationstatus);


--
-- Name: fk_localityelement_idhabitat; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT fk_localityelement_idhabitat FOREIGN KEY (idhabitat) REFERENCES habitat(idhabitat);


--
-- Name: fk_localityelement_idisland; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT fk_localityelement_idisland FOREIGN KEY (idisland) REFERENCES island(idisland);


--
-- Name: fk_localityelement_idislandgroup; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT fk_localityelement_idislandgroup FOREIGN KEY (idislandgroup) REFERENCES islandgroup(idislandgroup);


--
-- Name: fk_localityelement_idlocality; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT fk_localityelement_idlocality FOREIGN KEY (idlocality) REFERENCES locality(idlocality);


--
-- Name: fk_localityelement_idmunicipality; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT fk_localityelement_idmunicipality FOREIGN KEY (idmunicipality) REFERENCES municipality(idmunicipality);


--
-- Name: fk_localityelement_idsite_; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT fk_localityelement_idsite_ FOREIGN KEY (idsite_) REFERENCES site_(idsite_);


--
-- Name: fk_localityelement_idstateprovince; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT fk_localityelement_idstateprovince FOREIGN KEY (idstateprovince) REFERENCES stateprovince(idstateprovince);


--
-- Name: fk_localityelement_idwaterbody; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT fk_localityelement_idwaterbody FOREIGN KEY (idwaterbody) REFERENCES waterbody(idwaterbody);


--
-- Name: fk_monitoring_idcollector; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT fk_monitoring_idcollector FOREIGN KEY (idcollector) REFERENCES collector(idcollector);


--
-- Name: fk_monitoring_idcolorpantrap; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT fk_monitoring_idcolorpantrap FOREIGN KEY (idcolorpantrap) REFERENCES colorpantrap(idcolorpantrap);


--
-- Name: fk_monitoring_idcultivar; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT fk_monitoring_idcultivar FOREIGN KEY (idcultivar) REFERENCES cultivar(idcultivar);


--
-- Name: fk_monitoring_idculture; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT fk_monitoring_idculture FOREIGN KEY (idculture) REFERENCES culture(idculture);


--
-- Name: fk_monitoring_iddenomination; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT fk_monitoring_iddenomination FOREIGN KEY (iddenomination) REFERENCES denomination(iddenomination);


--
-- Name: fk_monitoring_iddigitizer; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT fk_monitoring_iddigitizer FOREIGN KEY (iddigitizer) REFERENCES digitizer(iddigitizer);


--
-- Name: fk_monitoring_idpredominantbiome; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT fk_monitoring_idpredominantbiome FOREIGN KEY (idpredominantbiome) REFERENCES predominantbiome(idpredominantbiome);


--
-- Name: fk_monitoring_idsupporttype; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT fk_monitoring_idsupporttype FOREIGN KEY (idsupporttype) REFERENCES supporttype(idsupporttype);


--
-- Name: fk_monitoring_idsurroundingsculture; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT fk_monitoring_idsurroundingsculture FOREIGN KEY (idsurroundingsculture) REFERENCES surroundingsculture(idsurroundingsculture);


--
-- Name: fk_monitoring_idtechnicalcollection; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT fk_monitoring_idtechnicalcollection FOREIGN KEY (idtechnicalcollection) REFERENCES technicalcollection(idtechnicalcollection);


--
-- Name: fk_nameaccordingto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT fk_nameaccordingto FOREIGN KEY (idnameaccordingto) REFERENCES nameaccordingto(idnameaccordingto);


--
-- Name: fk_namepublishedin; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT fk_namepublishedin FOREIGN KEY (idnamepublishedin) REFERENCES namepublishedin(idnamepublishedin);


--
-- Name: fk_occurrenceelement_idbehavior; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT fk_occurrenceelement_idbehavior FOREIGN KEY (idbehavior) REFERENCES behavior(idbehavior);


--
-- Name: fk_occurrenceelement_iddisposition; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT fk_occurrenceelement_iddisposition FOREIGN KEY (iddisposition) REFERENCES disposition(iddisposition);


--
-- Name: fk_occurrenceelement_idestablishmentmean; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT fk_occurrenceelement_idestablishmentmean FOREIGN KEY (idestablishmentmean) REFERENCES establishmentmean(idestablishmentmean);


--
-- Name: fk_occurrenceelement_idlifestage; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT fk_occurrenceelement_idlifestage FOREIGN KEY (idlifestage) REFERENCES lifestage(idlifestage);


--
-- Name: fk_occurrenceelement_idreproductivecondition; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT fk_occurrenceelement_idreproductivecondition FOREIGN KEY (idreproductivecondition) REFERENCES reproductivecondition(idreproductivecondition);


--
-- Name: fk_occurrenceelement_idsex; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT fk_occurrenceelement_idsex FOREIGN KEY (idsex) REFERENCES sex(idsex);


--
-- Name: fk_originalnameusage; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT fk_originalnameusage FOREIGN KEY (idoriginalnameusage) REFERENCES originalnameusage(idoriginalnameusage);


--
-- Name: fk_parentnameusage; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT fk_parentnameusage FOREIGN KEY (idparentnameusage) REFERENCES parentnameusage(idparentnameusage);


--
-- Name: fk_preparationrel; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialpreparation
    ADD CONSTRAINT fk_preparationrel FOREIGN KEY (idpreparation) REFERENCES preparation(idpreparation);


--
-- Name: fk_previousidentification_ididentificationelement; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY previousidentification
    ADD CONSTRAINT fk_previousidentification_ididentificationelement FOREIGN KEY (ididentificationelement) REFERENCES identificationelement(ididentificationelement);


--
-- Name: fk_previousidentification_idoccurrenceelement; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY previousidentification
    ADD CONSTRAINT fk_previousidentification_idoccurrenceelement FOREIGN KEY (idoccurrenceelement) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: fk_recordlevelelement_idbasisofrecord; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT fk_recordlevelelement_idbasisofrecord FOREIGN KEY (idbasisofrecord) REFERENCES basisofrecord(idbasisofrecord);


--
-- Name: fk_recordlevelelement_idcollectioncode; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT fk_recordlevelelement_idcollectioncode FOREIGN KEY (idcollectioncode) REFERENCES collectioncode(idcollectioncode);


--
-- Name: fk_recordlevelelement_iddataset; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT fk_recordlevelelement_iddataset FOREIGN KEY (iddataset) REFERENCES dataset(iddataset);


--
-- Name: fk_recordlevelelement_idinstitutioncode; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT fk_recordlevelelement_idinstitutioncode FOREIGN KEY (idinstitutioncode) REFERENCES institutioncode(idinstitutioncode);


--
-- Name: fk_recordlevelelement_idlanguage; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT fk_recordlevelelement_idlanguage FOREIGN KEY (idlanguage) REFERENCES language(idlanguage);


--
-- Name: fk_recordlevelelement_idownerinstitution; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT fk_recordlevelelement_idownerinstitution FOREIGN KEY (idownerinstitution) REFERENCES ownerinstitution(idownerinstitution);


--
-- Name: fk_recordlevelelement_idtype; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT fk_recordlevelelement_idtype FOREIGN KEY (idtype) REFERENCES type(idtype);


--
-- Name: fk_specimen_idcuratorialelement; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT fk_specimen_idcuratorialelement FOREIGN KEY (idcuratorialelement) REFERENCES curatorialelement(idcuratorialelement);


--
-- Name: fk_specimen_ideventelement; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT fk_specimen_ideventelement FOREIGN KEY (ideventelement) REFERENCES eventelement(ideventelement);


--
-- Name: fk_specimen_idgeospatialelement; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT fk_specimen_idgeospatialelement FOREIGN KEY (idgeospatialelement) REFERENCES geospatialelement(idgeospatialelement);


--
-- Name: fk_specimen_ididentificationelement; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT fk_specimen_ididentificationelement FOREIGN KEY (ididentificationelement) REFERENCES identificationelement(ididentificationelement);


--
-- Name: fk_specimen_idlocalityelement; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT fk_specimen_idlocalityelement FOREIGN KEY (idlocalityelement) REFERENCES localityelement(idlocalityelement);


--
-- Name: fk_specimen_idmonitoring; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT fk_specimen_idmonitoring FOREIGN KEY (idmonitoring) REFERENCES monitoring(idmonitoring);


--
-- Name: fk_specimen_idoccurrenceelement; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT fk_specimen_idoccurrenceelement FOREIGN KEY (idoccurrenceelement) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: fk_specimen_idrecordlevelelement; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT fk_specimen_idrecordlevelelement FOREIGN KEY (idrecordlevelelement) REFERENCES recordlevelelement(idrecordlevelelement);


--
-- Name: fk_specimen_idtaxonomicelement; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT fk_specimen_idtaxonomicelement FOREIGN KEY (idtaxonomicelement) REFERENCES taxonomicelement(idtaxonomicelement);


--
-- Name: fk_subgenus; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT fk_subgenus FOREIGN KEY (idsubgenus) REFERENCES subgenus(idsubgenus);


--
-- Name: fk_taxonconcept; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT fk_taxonconcept FOREIGN KEY (idtaxonconcept) REFERENCES taxonconcept(idtaxonconcept);


--
-- Name: fk_taxonomicelement_idgenus; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT fk_taxonomicelement_idgenus FOREIGN KEY (idgenus) REFERENCES genus(idgenus);


--
-- Name: fk_taxonomicelement_idkingdom; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT fk_taxonomicelement_idkingdom FOREIGN KEY (idkingdom) REFERENCES kingdom(idkingdom);


--
-- Name: fk_taxonomicelement_idoriginalnameusage; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT fk_taxonomicelement_idoriginalnameusage FOREIGN KEY (idoriginalnameusage) REFERENCES originalnameusage(idoriginalnameusage);


--
-- Name: fk_taxonomicelement_idtaxonconcept; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT fk_taxonomicelement_idtaxonconcept FOREIGN KEY (idtaxonconcept) REFERENCES taxonconcept(idtaxonconcept);


--
-- Name: fk_taxonomicstatus; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT fk_taxonomicstatus FOREIGN KEY (idtaxonomicstatus) REFERENCES taxonomicstatus(idtaxonomicstatus);


--
-- Name: georeferencesourcesgeospatial_idgeoreferencesources_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY geospatialgeoreferencesource
    ADD CONSTRAINT georeferencesourcesgeospatial_idgeoreferencesources_fkey FOREIGN KEY (idgeoreferencesource) REFERENCES georeferencesource(idgeoreferencesource);


--
-- Name: georeferencesourcesgeospatial_idgeospatialelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY geospatialgeoreferencesource
    ADD CONSTRAINT georeferencesourcesgeospatial_idgeospatialelements_fkey FOREIGN KEY (idgeospatialelement) REFERENCES geospatialelement(idgeospatialelement);


--
-- Name: geospatialelements_idgeoreferenceverificationstatus_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY geospatialelement
    ADD CONSTRAINT geospatialelements_idgeoreferenceverificationstatus_fkey FOREIGN KEY (idgeoreferenceverificationstatus) REFERENCES georeferenceverificationstatus(idgeoreferenceverificationstatus);


--
-- Name: groupdynamicproperties_ibfk_idgroup; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY groupattributes
    ADD CONSTRAINT groupdynamicproperties_ibfk_idgroup FOREIGN KEY ("idGroup") REFERENCES groups("idGroup");


--
-- Name: grouppages_ibfk_idgroup; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grouppages
    ADD CONSTRAINT grouppages_ibfk_idgroup FOREIGN KEY ("idGroup") REFERENCES groups("idGroup");


--
-- Name: grouppages_ibfk_idpage; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grouppages
    ADD CONSTRAINT grouppages_ibfk_idpage FOREIGN KEY ("idPage") REFERENCES page(idpage);


--
-- Name: iddispo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialelement
    ADD CONSTRAINT iddispo FOREIGN KEY (iddisposition) REFERENCES disposition(iddisposition);


--
-- Name: identificationelements_ibfk_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY identificationelement
    ADD CONSTRAINT identificationelements_ibfk_1 FOREIGN KEY (ididentificationqualifier) REFERENCES identificationqualifier(ididentificationqualifier);


--
-- Name: identificationidentifiedby_ididentificationelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY identificationidentifiedby
    ADD CONSTRAINT identificationidentifiedby_ididentificationelement_fkey FOREIGN KEY (ididentificationelement) REFERENCES identificationelement(ididentificationelement) ON DELETE CASCADE;


--
-- Name: identificationidentifiedby_ididentifiedby_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY identificationidentifiedby
    ADD CONSTRAINT identificationidentifiedby_ididentifiedby_fkey FOREIGN KEY (ididentifiedby) REFERENCES identifiedby(ididentifiedby) ON DELETE CASCADE;


--
-- Name: identificationkey_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY identificationkey
    ADD CONSTRAINT identificationkey_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement);


--
-- Name: identificationkey_idspecies_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY identificationkey
    ADD CONSTRAINT identificationkey_idspecies_fkey FOREIGN KEY (idspecies) REFERENCES species(idspecies);


--
-- Name: identificationtypestatus_ididentificationelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY identificationtypestatus
    ADD CONSTRAINT identificationtypestatus_ididentificationelement_fkey FOREIGN KEY (ididentificationelement) REFERENCES identificationelement(ididentificationelement) ON DELETE CASCADE;


--
-- Name: identificationtypestatus_idtypestatus_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY identificationtypestatus
    ADD CONSTRAINT identificationtypestatus_idtypestatus_fkey FOREIGN KEY (idtypestatus) REFERENCES typestatus(idtypestatus) ON DELETE CASCADE;


--
-- Name: identifiedbycuratorial_idcuratorialelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialidentifiedby
    ADD CONSTRAINT identifiedbycuratorial_idcuratorialelements_fkey FOREIGN KEY (idcuratorialelement) REFERENCES curatorialelement(idcuratorialelement);


--
-- Name: idhabit; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT idhabit FOREIGN KEY (idhabitat) REFERENCES habitat(idhabitat);


--
-- Name: interaction_idspecimen1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY interaction
    ADD CONSTRAINT interaction_idspecimen1_fkey FOREIGN KEY (idspecimen1) REFERENCES specimen(idspecimen) ON DELETE CASCADE;


--
-- Name: interaction_idspecimen2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY interaction
    ADD CONSTRAINT interaction_idspecimen2_fkey FOREIGN KEY (idspecimen2) REFERENCES specimen(idspecimen) ON DELETE CASCADE;


--
-- Name: interactionelements_ibfk_idinteractiontype; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY interaction
    ADD CONSTRAINT interactionelements_ibfk_idinteractiontype FOREIGN KEY (idinteractiontype) REFERENCES interactiontype(idinteractiontype);


--
-- Name: lask_task_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY process_log_dq
    ADD CONSTRAINT lask_task_fk FOREIGN KEY (id_last_task) REFERENCES type_log_dq(id);


--
-- Name: localityelement_idsite__fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT localityelement_idsite__fkey FOREIGN KEY (idsite_) REFERENCES site_(idsite_);


--
-- Name: localityelements_ibfk_idcontinent; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT localityelements_ibfk_idcontinent FOREIGN KEY (idcontinent) REFERENCES continent(idcontinent);


--
-- Name: localityelements_ibfk_idcountry; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT localityelements_ibfk_idcountry FOREIGN KEY (idcountry) REFERENCES country(idcountry);


--
-- Name: localityelements_ibfk_idcounty; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT localityelements_ibfk_idcounty FOREIGN KEY (idcounty) REFERENCES county(idcounty);


--
-- Name: localityelements_ibfk_idisland; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT localityelements_ibfk_idisland FOREIGN KEY (idisland) REFERENCES island(idisland);


--
-- Name: localityelements_ibfk_idislandgroup; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT localityelements_ibfk_idislandgroup FOREIGN KEY (idislandgroup) REFERENCES islandgroup(idislandgroup);


--
-- Name: localityelements_ibfk_idlocality; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT localityelements_ibfk_idlocality FOREIGN KEY (idlocality) REFERENCES locality(idlocality);


--
-- Name: localityelements_ibfk_idstateprovince; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT localityelements_ibfk_idstateprovince FOREIGN KEY (idstateprovince) REFERENCES stateprovince(idstateprovince);


--
-- Name: localityelements_ibfk_idwaterbody; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT localityelements_ibfk_idwaterbody FOREIGN KEY (idwaterbody) REFERENCES waterbody(idwaterbody);


--
-- Name: localityelements_idgeoreferenceverificationstatus_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT localityelements_idgeoreferenceverificationstatus_fkey FOREIGN KEY (idgeoreferenceverificationstatus) REFERENCES georeferenceverificationstatus(idgeoreferenceverificationstatus);


--
-- Name: localitygeoreferencedby_idgeoreferencedby_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localitygeoreferencedby
    ADD CONSTRAINT localitygeoreferencedby_idgeoreferencedby_fkey FOREIGN KEY (idgeoreferencedby) REFERENCES georeferencedby(idgeoreferencedby) ON DELETE CASCADE;


--
-- Name: localitygeoreferencedby_idlocalityelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localitygeoreferencedby
    ADD CONSTRAINT localitygeoreferencedby_idlocalityelement_fkey FOREIGN KEY (idlocalityelement) REFERENCES localityelement(idlocalityelement) ON DELETE CASCADE;


--
-- Name: localitygeoreferencesource_idgeoreferencesource_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localitygeoreferencesource
    ADD CONSTRAINT localitygeoreferencesource_idgeoreferencesource_fkey FOREIGN KEY (idgeoreferencesource) REFERENCES georeferencesource(idgeoreferencesource) ON DELETE CASCADE;


--
-- Name: localitygeoreferencesource_idlocalityelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localitygeoreferencesource
    ADD CONSTRAINT localitygeoreferencesource_idlocalityelement_fkey FOREIGN KEY (idlocalityelement) REFERENCES localityelement(idlocalityelement) ON DELETE CASCADE;


--
-- Name: log_dq_deleted_items_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_dq
    ADD CONSTRAINT log_dq_deleted_items_fk FOREIGN KEY (id_log_dq_deleted_items) REFERENCES log_dq_deleted_items(id);


--
-- Name: log_dq_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_dq_fields
    ADD CONSTRAINT log_dq_fk FOREIGN KEY (id_log_dq) REFERENCES log_dq(id);


--
-- Name: log_iduser_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log
    ADD CONSTRAINT log_iduser_fkey FOREIGN KEY (iduser) REFERENCES users("idUser");


--
-- Name: media_idcapturedevice_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY media
    ADD CONSTRAINT media_idcapturedevice_fkey FOREIGN KEY (idcapturedevice) REFERENCES capturedevice(idcapturedevice);


--
-- Name: media_idcategorymedia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY media
    ADD CONSTRAINT media_idcategorymedia_fkey FOREIGN KEY (idcategorymedia) REFERENCES categorymedia(idcategorymedia);


--
-- Name: media_idlanguages_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY media
    ADD CONSTRAINT media_idlanguages_fkey FOREIGN KEY (idlanguage) REFERENCES language(idlanguage);


--
-- Name: media_idmetadataprovider_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY media
    ADD CONSTRAINT media_idmetadataprovider_fkey FOREIGN KEY (idmetadataprovider) REFERENCES metadataprovider(idmetadataprovider);


--
-- Name: media_idsubcategorymedia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY media
    ADD CONSTRAINT media_idsubcategorymedia_fkey FOREIGN KEY (idsubcategorymedia) REFERENCES subcategorymedia(idsubcategorymedia);


--
-- Name: media_idsubtype_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY media
    ADD CONSTRAINT media_idsubtype_fkey FOREIGN KEY (idsubtype) REFERENCES subtype(idsubtype);


--
-- Name: media_idtypemedia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY media
    ADD CONSTRAINT media_idtypemedia_fkey FOREIGN KEY (idtypemedia) REFERENCES typemedia(idtypemedia);


--
-- Name: monitoring_idcollector_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT monitoring_idcollector_fkey FOREIGN KEY (idcollector) REFERENCES collector(idcollector);


--
-- Name: monitoring_idcolorpantrap_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT monitoring_idcolorpantrap_fkey FOREIGN KEY (idcolorpantrap) REFERENCES colorpantrap(idcolorpantrap);


--
-- Name: monitoring_idcultivar_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT monitoring_idcultivar_fkey FOREIGN KEY (idcultivar) REFERENCES cultivar(idcultivar);


--
-- Name: monitoring_idculture_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT monitoring_idculture_fkey FOREIGN KEY (idculture) REFERENCES culture(idculture);


--
-- Name: monitoring_iddenomination_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT monitoring_iddenomination_fkey FOREIGN KEY (iddenomination) REFERENCES denomination(iddenomination);


--
-- Name: monitoring_iddigitizer_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT monitoring_iddigitizer_fkey FOREIGN KEY (iddigitizer) REFERENCES digitizer(iddigitizer);


--
-- Name: monitoring_idpredominantbiome_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT monitoring_idpredominantbiome_fkey FOREIGN KEY (idpredominantbiome) REFERENCES predominantbiome(idpredominantbiome);


--
-- Name: monitoring_idsupporttype_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT monitoring_idsupporttype_fkey FOREIGN KEY (idsupporttype) REFERENCES supporttype(idsupporttype);


--
-- Name: monitoring_idsurroundingsculture_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT monitoring_idsurroundingsculture_fkey FOREIGN KEY (idsurroundingsculture) REFERENCES surroundingsculture(idsurroundingsculture);


--
-- Name: monitoring_idsurroundingsvegetation_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT monitoring_idsurroundingsvegetation_fkey FOREIGN KEY (idsurroundingsvegetation) REFERENCES surroundingsvegetation(idsurroundingsvegetation);


--
-- Name: monitoring_idtechnicalcollection_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY monitoring
    ADD CONSTRAINT monitoring_idtechnicalcollection_fkey FOREIGN KEY (idtechnicalcollection) REFERENCES technicalcollection(idtechnicalcollection);


--
-- Name: munic; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY localityelement
    ADD CONSTRAINT munic FOREIGN KEY (idmunicipality) REFERENCES municipality(idmunicipality);


--
-- Name: occurrence_idbehavior_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT occurrence_idbehavior_fkey FOREIGN KEY (idbehavior) REFERENCES behavior(idbehavior);


--
-- Name: occurrence_iddisposition_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT occurrence_iddisposition_fkey FOREIGN KEY (iddisposition) REFERENCES disposition(iddisposition);


--
-- Name: occurrence_idestablishmentmeans_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT occurrence_idestablishmentmeans_fkey FOREIGN KEY (idestablishmentmean) REFERENCES establishmentmean(idestablishmentmean);


--
-- Name: occurrence_idlifestage_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT occurrence_idlifestage_fkey FOREIGN KEY (idlifestage) REFERENCES lifestage(idlifestage);


--
-- Name: occurrence_idreproductivecondition_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT occurrence_idreproductivecondition_fkey FOREIGN KEY (idreproductivecondition) REFERENCES reproductivecondition(idreproductivecondition);


--
-- Name: occurrence_idsex_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceelement
    ADD CONSTRAINT occurrence_idsex_fkey FOREIGN KEY (idsex) REFERENCES sex(idsex);


--
-- Name: occurrenceassociatedsequence_idassociatedsequence_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceassociatedsequence
    ADD CONSTRAINT occurrenceassociatedsequence_idassociatedsequence_fkey FOREIGN KEY (idassociatedsequence) REFERENCES associatedsequence(idassociatedsequence) ON DELETE CASCADE;


--
-- Name: occurrenceassociatedsequence_idoccurrenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceassociatedsequence
    ADD CONSTRAINT occurrenceassociatedsequence_idoccurrenceelement_fkey FOREIGN KEY (idoccurrenceelement) REFERENCES occurrenceelement(idoccurrenceelement) ON DELETE CASCADE;


--
-- Name: occurrenceindividual_idindividual_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceindividual
    ADD CONSTRAINT occurrenceindividual_idindividual_fkey FOREIGN KEY (idindividual) REFERENCES individual(idindividual) ON DELETE CASCADE;


--
-- Name: occurrenceindividual_idoccurrenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrenceindividual
    ADD CONSTRAINT occurrenceindividual_idoccurrenceelement_fkey FOREIGN KEY (idoccurrenceelement) REFERENCES occurrenceelement(idoccurrenceelement) ON DELETE CASCADE;


--
-- Name: occurrencepreparation_idoccurrenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrencepreparation
    ADD CONSTRAINT occurrencepreparation_idoccurrenceelement_fkey FOREIGN KEY (idoccurrenceelement) REFERENCES occurrenceelement(idoccurrenceelement) ON DELETE CASCADE;


--
-- Name: occurrencepreparation_idpreparation_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrencepreparation
    ADD CONSTRAINT occurrencepreparation_idpreparation_fkey FOREIGN KEY (idpreparation) REFERENCES preparation(idpreparation) ON DELETE CASCADE;


--
-- Name: occurrencerecordedby_idoccurrenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrencerecordedby
    ADD CONSTRAINT occurrencerecordedby_idoccurrenceelement_fkey FOREIGN KEY (idoccurrenceelement) REFERENCES occurrenceelement(idoccurrenceelement) ON DELETE CASCADE;


--
-- Name: occurrencerecordedby_idrecordedby_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY occurrencerecordedby
    ADD CONSTRAINT occurrencerecordedby_idrecordedby_fkey FOREIGN KEY (idrecordedby) REFERENCES recordedby(idrecordedby) ON DELETE CASCADE;


--
-- Name: ownerinstitution; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT ownerinstitution FOREIGN KEY (idownerinstitution) REFERENCES ownerinstitution(idownerinstitution);


--
-- Name: previousidentifications_ididentificationelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY previousidentification
    ADD CONSTRAINT previousidentifications_ididentificationelements_fkey FOREIGN KEY (ididentificationelement) REFERENCES identificationelement(ididentificationelement);


--
-- Name: previousidentifications_idoccurrenceelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY previousidentification
    ADD CONSTRAINT previousidentifications_idoccurrenceelements_fkey FOREIGN KEY (idoccurrenceelement) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: process_execution_process; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY process_specimens_execution
    ADD CONSTRAINT process_execution_process FOREIGN KEY (id_process) REFERENCES process_log_dq(id);


--
-- Name: process_execution_specimen; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY process_specimens_execution
    ADD CONSTRAINT process_execution_specimen FOREIGN KEY (id_specimen) REFERENCES specimen(idspecimen);


--
-- Name: process_execution_type_log_dq_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY process_specimens_execution
    ADD CONSTRAINT process_execution_type_log_dq_fk FOREIGN KEY (id_type_dq) REFERENCES type_log_dq(id);


--
-- Name: process_taxons_execution_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY process_taxons_execution
    ADD CONSTRAINT process_taxons_execution_fk FOREIGN KEY (id_process) REFERENCES process_log_dq(id);


--
-- Name: process_taxons_execution_type_log_dq_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY process_taxons_execution
    ADD CONSTRAINT process_taxons_execution_type_log_dq_fk FOREIGN KEY (id_type_dq) REFERENCES type_log_dq(id);


--
-- Name: recordedbycuratorial_idcuratorialelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialrecordedby
    ADD CONSTRAINT recordedbycuratorial_idcuratorialelements_fkey FOREIGN KEY (idcuratorialelement) REFERENCES curatorialelement(idcuratorialelement);


--
-- Name: recordedbycuratorial_idrecordedby_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialrecordedby
    ADD CONSTRAINT recordedbycuratorial_idrecordedby_fkey FOREIGN KEY (idrecordedby) REFERENCES recordedby(idrecordedby);


--
-- Name: recordleveldynamicproperty_iddynamicproperty_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordleveldynamicproperty
    ADD CONSTRAINT recordleveldynamicproperty_iddynamicproperty_fkey FOREIGN KEY (iddynamicproperty) REFERENCES dynamicproperty(iddynamicproperty) ON DELETE CASCADE;


--
-- Name: recordleveldynamicproperty_idrecordlevelelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordleveldynamicproperty
    ADD CONSTRAINT recordleveldynamicproperty_idrecordlevelelement_fkey FOREIGN KEY (idrecordlevelelement) REFERENCES recordlevelelement(idrecordlevelelement) ON DELETE CASCADE;


--
-- Name: recordlevelelements_ibfk_idbasisofrecord; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT recordlevelelements_ibfk_idbasisofrecord FOREIGN KEY (idbasisofrecord) REFERENCES basisofrecord(idbasisofrecord);


--
-- Name: recordlevelelements_ibfk_idcollectioncode; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT recordlevelelements_ibfk_idcollectioncode FOREIGN KEY (idcollectioncode) REFERENCES collectioncode(idcollectioncode);


--
-- Name: recordlevelelements_ibfk_idinstitutioncode; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT recordlevelelements_ibfk_idinstitutioncode FOREIGN KEY (idinstitutioncode) REFERENCES institutioncode(idinstitutioncode);


--
-- Name: recordlevelelements_iddataset_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT recordlevelelements_iddataset_fkey FOREIGN KEY (iddataset) REFERENCES dataset(iddataset);


--
-- Name: recordlevelelements_idlanguage_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT recordlevelelements_idlanguage_fkey FOREIGN KEY (idlanguage) REFERENCES language(idlanguage);


--
-- Name: recordlevelelements_idtype_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY recordlevelelement
    ADD CONSTRAINT recordlevelelements_idtype_fkey FOREIGN KEY (idtype) REFERENCES type(idtype);


--
-- Name: referenceafiliation_idafiliation_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceafiliation
    ADD CONSTRAINT referenceafiliation_idafiliation_fkey FOREIGN KEY (idafiliation) REFERENCES afiliation(idafiliation) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referenceafiliation_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceafiliation
    ADD CONSTRAINT referenceafiliation_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referencebiome_idbiome_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencebiome
    ADD CONSTRAINT referencebiome_idbiome_fkey FOREIGN KEY (idbiome) REFERENCES biome(idbiome) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referencebiome_idreferencelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencebiome
    ADD CONSTRAINT referencebiome_idreferencelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referencecreator_idcreator_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencecreator
    ADD CONSTRAINT referencecreator_idcreator_fkey FOREIGN KEY (idcreator) REFERENCES creator(idcreator);


--
-- Name: referencecreator_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencecreator
    ADD CONSTRAINT referencecreator_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement);


--
-- Name: referenceelement_idsource_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceelement
    ADD CONSTRAINT referenceelement_idsource_fkey FOREIGN KEY (idsource) REFERENCES source(idsource) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referencekeyword_idkeyword_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencekeyword
    ADD CONSTRAINT referencekeyword_idkeyword_fkey FOREIGN KEY (idkeyword) REFERENCES keyword(idkeyword) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referencekeyword_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencekeyword
    ADD CONSTRAINT referencekeyword_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement);


--
-- Name: referenceoccurrence_idoccurrenceelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedreferences
    ADD CONSTRAINT referenceoccurrence_idoccurrenceelements_fkey FOREIGN KEY (idoccurrenceelements) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: referenceoccurrence_idreferences_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY associatedreferences
    ADD CONSTRAINT referenceoccurrence_idreferences_fkey FOREIGN KEY (idreferenceselements) REFERENCES referenceelement(idreferenceelement);


--
-- Name: referenceplantcommonname_idplantcommonname_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceplantcommonname
    ADD CONSTRAINT referenceplantcommonname_idplantcommonname_fkey FOREIGN KEY (idplantcommonname) REFERENCES plantcommonname(idplantcommonname) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referenceplantcommonname_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceplantcommonname
    ADD CONSTRAINT referenceplantcommonname_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referenceplantfamily_idplantfamily_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceplantfamily
    ADD CONSTRAINT referenceplantfamily_idplantfamily_fkey FOREIGN KEY (idplantfamily) REFERENCES plantfamily(idplantfamily) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referenceplantfamily_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceplantfamily
    ADD CONSTRAINT referenceplantfamily_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referenceplantspecies_idplantspecies_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceplantspecies
    ADD CONSTRAINT referenceplantspecies_idplantspecies_fkey FOREIGN KEY (idplantspecies) REFERENCES plantspecies(idplantspecies) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referenceplantspecies_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceplantspecies
    ADD CONSTRAINT referenceplantspecies_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referencepollinatorcommonname_idpollinatorcommonname_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencepollinatorcommonname
    ADD CONSTRAINT referencepollinatorcommonname_idpollinatorcommonname_fkey FOREIGN KEY (idpollinatorcommonname) REFERENCES pollinatorcommonname(idpollinatorcommonname) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referencepollinatorcommonname_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencepollinatorcommonname
    ADD CONSTRAINT referencepollinatorcommonname_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referencepollinatorfamily_idpollinatorfamily_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencepollinatorfamily
    ADD CONSTRAINT referencepollinatorfamily_idpollinatorfamily_fkey FOREIGN KEY (idpollinatorfamily) REFERENCES pollinatorfamily(idpollinatorfamily) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referencepollinatorfamily_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencepollinatorfamily
    ADD CONSTRAINT referencepollinatorfamily_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement);


--
-- Name: referencepollinatorspecies_idpollinatorspecies_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencepollinatorspecies
    ADD CONSTRAINT referencepollinatorspecies_idpollinatorspecies_fkey FOREIGN KEY (idpollinatorspecies) REFERENCES pollinatorspecies(idpollinatorspecies) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: referencepollinatorspecies_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencepollinatorspecies
    ADD CONSTRAINT referencepollinatorspecies_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement);


--
-- Name: referenceselements_ibfk_idcreators; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceelement
    ADD CONSTRAINT referenceselements_ibfk_idcreators FOREIGN KEY (idcreator) REFERENCES creator(idcreator);


--
-- Name: referenceselements_ibfk_idfileformat; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceelement
    ADD CONSTRAINT referenceselements_ibfk_idfileformat FOREIGN KEY (idfileformat) REFERENCES fileformat(idfileformat);


--
-- Name: referenceselements_ibfk_idlanguages; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceelement
    ADD CONSTRAINT referenceselements_ibfk_idlanguages FOREIGN KEY (idlanguage) REFERENCES language(idlanguage);


--
-- Name: referenceselements_ibfk_idpublishers; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceelement
    ADD CONSTRAINT referenceselements_ibfk_idpublishers FOREIGN KEY (idpublisher) REFERENCES publisher(idpublisher);


--
-- Name: referenceselements_ibfk_idtypereferencess; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceelement
    ADD CONSTRAINT referenceselements_ibfk_idtypereferencess FOREIGN KEY (idtypereference) REFERENCES typereference(idtypereference);


--
-- Name: referenceselements_idsubtypereferences_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referenceelement
    ADD CONSTRAINT referenceselements_idsubtypereferences_fkey FOREIGN KEY (idsubtypereference) REFERENCES subtypereference(idsubtypereference);


--
-- Name: referencesidentification_ididentificationelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencesidentification
    ADD CONSTRAINT referencesidentification_ididentificationelements_fkey FOREIGN KEY (ididentificationelements) REFERENCES identificationelement(ididentificationelement);


--
-- Name: referencesidentification_idreferenceselements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencesidentification
    ADD CONSTRAINT referencesidentification_idreferenceselements_fkey FOREIGN KEY (idreferenceselements) REFERENCES referenceelement(idreferenceelement);


--
-- Name: referencesspecie_idreferenceselements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencesspecie
    ADD CONSTRAINT referencesspecie_idreferenceselements_fkey FOREIGN KEY (idreferenceselements) REFERENCES referenceelement(idreferenceelement);


--
-- Name: referencestaxonomic_idreferenceselements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencestaxonomic
    ADD CONSTRAINT referencestaxonomic_idreferenceselements_fkey FOREIGN KEY (idreferenceselements) REFERENCES referenceelement(idreferenceelement);


--
-- Name: referencestaxonomic_idtaxonomicelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY referencestaxonomic
    ADD CONSTRAINT referencestaxonomic_idtaxonomicelements_fkey FOREIGN KEY (idtaxonomicelements) REFERENCES taxonomicelement(idtaxonomicelement);


--
-- Name: specie_idinstitutioncode_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY species
    ADD CONSTRAINT specie_idinstitutioncode_fkey FOREIGN KEY (idinstitutioncode) REFERENCES institutioncode(idinstitutioncode);


--
-- Name: specie_idlanguage_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY species
    ADD CONSTRAINT specie_idlanguage_fkey FOREIGN KEY (idlanguage) REFERENCES language(idlanguage);


--
-- Name: specie_idtaxonomicelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY species
    ADD CONSTRAINT specie_idtaxonomicelement_fkey FOREIGN KEY (idtaxonomicelement) REFERENCES taxonomicelement(idtaxonomicelement);


--
-- Name: speciescontributor_idcontributor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciescontributor
    ADD CONSTRAINT speciescontributor_idcontributor_fkey FOREIGN KEY (idcontributor) REFERENCES contributor(idcontributor);


--
-- Name: speciescontributor_idspecies_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciescontributor
    ADD CONSTRAINT speciescontributor_idspecies_fkey FOREIGN KEY (idspecies) REFERENCES species(idspecies);


--
-- Name: speciesidkey_idspecies_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciesidkey
    ADD CONSTRAINT speciesidkey_idspecies_fkey FOREIGN KEY (idspecies) REFERENCES species(idspecies) ON DELETE CASCADE;


--
-- Name: speciesmedia_idmedia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciesmedia
    ADD CONSTRAINT speciesmedia_idmedia_fkey FOREIGN KEY (idmedia) REFERENCES media(idmedia) ON DELETE CASCADE;


--
-- Name: speciesmedia_idspecies_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciesmedia
    ADD CONSTRAINT speciesmedia_idspecies_fkey FOREIGN KEY (idspecies) REFERENCES species(idspecies) ON DELETE CASCADE;


--
-- Name: speciespaper_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciespaper
    ADD CONSTRAINT speciespaper_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement) ON DELETE CASCADE;


--
-- Name: speciespaper_idspecies_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciespaper
    ADD CONSTRAINT speciespaper_idspecies_fkey FOREIGN KEY (idspecies) REFERENCES species(idspecies) ON DELETE CASCADE;


--
-- Name: speciespublicationreference_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciespublicationreference
    ADD CONSTRAINT speciespublicationreference_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement) ON DELETE CASCADE;


--
-- Name: speciespublicationreference_idspecies_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciespublicationreference
    ADD CONSTRAINT speciespublicationreference_idspecies_fkey FOREIGN KEY (idspecies) REFERENCES species(idspecies) ON DELETE CASCADE;


--
-- Name: speciesreference_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciesreference
    ADD CONSTRAINT speciesreference_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement) ON DELETE CASCADE;


--
-- Name: speciesreference_idspecies_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciesreference
    ADD CONSTRAINT speciesreference_idspecies_fkey FOREIGN KEY (idspecies) REFERENCES species(idspecies) ON DELETE CASCADE;


--
-- Name: speciesrelatedname_idrelatedname_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciesrelatedname
    ADD CONSTRAINT speciesrelatedname_idrelatedname_fkey FOREIGN KEY (idrelatedname) REFERENCES relatedname(idrelatedname);


--
-- Name: speciesrelatedname_idspecies_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciesrelatedname
    ADD CONSTRAINT speciesrelatedname_idspecies_fkey FOREIGN KEY (idspecies) REFERENCES species(idspecies);


--
-- Name: speciessynonym_idspecies_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciessynonym
    ADD CONSTRAINT speciessynonym_idspecies_fkey FOREIGN KEY (idspecies) REFERENCES species(idspecies);


--
-- Name: speciessynonym_idsynonym_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciessynonym
    ADD CONSTRAINT speciessynonym_idsynonym_fkey FOREIGN KEY (idsynonym) REFERENCES synonym(idsynonym);


--
-- Name: specimen_idcuratorialelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT specimen_idcuratorialelement_fkey FOREIGN KEY (idcuratorialelement) REFERENCES curatorialelement(idcuratorialelement);


--
-- Name: specimen_ideventelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT specimen_ideventelement_fkey FOREIGN KEY (ideventelement) REFERENCES eventelement(ideventelement);


--
-- Name: specimen_idgeospatialelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT specimen_idgeospatialelement_fkey FOREIGN KEY (idgeospatialelement) REFERENCES geospatialelement(idgeospatialelement);


--
-- Name: specimen_ididentificationelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT specimen_ididentificationelement_fkey FOREIGN KEY (ididentificationelement) REFERENCES identificationelement(ididentificationelement);


--
-- Name: specimen_idlocalityelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT specimen_idlocalityelement_fkey FOREIGN KEY (idlocalityelement) REFERENCES localityelement(idlocalityelement);


--
-- Name: specimen_idmonitoring_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT specimen_idmonitoring_fkey FOREIGN KEY (idmonitoring) REFERENCES monitoring(idmonitoring);


--
-- Name: specimen_idoccurrenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT specimen_idoccurrenceelement_fkey FOREIGN KEY (idoccurrenceelement) REFERENCES occurrenceelement(idoccurrenceelement);


--
-- Name: specimen_idtaxonomicelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT specimen_idtaxonomicelement_fkey FOREIGN KEY (idtaxonomicelement) REFERENCES taxonomicelement(idtaxonomicelement);


--
-- Name: specimen_log_dq_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_dq
    ADD CONSTRAINT specimen_log_dq_fk FOREIGN KEY (id_specimen) REFERENCES specimen(idspecimen);


--
-- Name: specimenelement_idrecordlevelelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimen
    ADD CONSTRAINT specimenelement_idrecordlevelelement_fkey FOREIGN KEY (idrecordlevelelement) REFERENCES recordlevelelement(idrecordlevelelement);


--
-- Name: specimenmedia_idmedia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimenmedia
    ADD CONSTRAINT specimenmedia_idmedia_fkey FOREIGN KEY (idmedia) REFERENCES media(idmedia);


--
-- Name: specimenmedia_idspecimen_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimenmedia
    ADD CONSTRAINT specimenmedia_idspecimen_fkey FOREIGN KEY (idspecimen) REFERENCES specimen(idspecimen);


--
-- Name: specimenreference_idreferenceelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimenreference
    ADD CONSTRAINT specimenreference_idreferenceelement_fkey FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement);


--
-- Name: specimenreference_idspecimen_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY specimenreference
    ADD CONSTRAINT specimenreference_idspecimen_fkey FOREIGN KEY (idspecimen) REFERENCES specimen(idspecimen);


--
-- Name: ssps; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciescreator
    ADD CONSTRAINT ssps FOREIGN KEY (idspecies) REFERENCES species(idspecies) ON DELETE CASCADE;


--
-- Name: subjectcategorymedia_idmedia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mediasubjectcategory
    ADD CONSTRAINT subjectcategorymedia_idmedia_fkey FOREIGN KEY (idmedia) REFERENCES media(idmedia);


--
-- Name: subjectcategorymedia_idsubjectcategory_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mediasubjectcategory
    ADD CONSTRAINT subjectcategorymedia_idsubjectcategory_fkey FOREIGN KEY (idsubjectcategory) REFERENCES subjectcategory(idsubjectcategory);


--
-- Name: tagmedia_idmedia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mediatag
    ADD CONSTRAINT tagmedia_idmedia_fkey FOREIGN KEY (idmedia) REFERENCES media(idmedia);


--
-- Name: tagmedia_idtag_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mediatag
    ADD CONSTRAINT tagmedia_idtag_fkey FOREIGN KEY (idtag) REFERENCES tag(idtag);


--
-- Name: taxonomicelement_idspeciesname_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelement_idspeciesname_fkey FOREIGN KEY (idspeciesname) REFERENCES speciesname(idspeciesname);


--
-- Name: taxonomicelement_idsubspecies_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelement_idsubspecies_fkey FOREIGN KEY (idsubspecies) REFERENCES subspecies(idsubspecies);


--
-- Name: taxonomicelement_idsubtribe_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelement_idsubtribe_fkey FOREIGN KEY (idsubtribe) REFERENCES subtribe(idsubtribe);


--
-- Name: taxonomicelement_idtribe_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelement_idtribe_fkey FOREIGN KEY (idtribe) REFERENCES tribe(idtribe);


--
-- Name: taxonomicelementcommonname_idcommonname_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelementcommonname
    ADD CONSTRAINT taxonomicelementcommonname_idcommonname_fkey FOREIGN KEY (idcommonname) REFERENCES commonname(idcommonname);


--
-- Name: taxonomicelementcommonname_idtaxonomicelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelementcommonname
    ADD CONSTRAINT taxonomicelementcommonname_idtaxonomicelement_fkey FOREIGN KEY (idtaxonomicelement) REFERENCES taxonomicelement(idtaxonomicelement);


--
-- Name: taxonomicelementrelatedname_idrelatedname_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelementrelatedname
    ADD CONSTRAINT taxonomicelementrelatedname_idrelatedname_fkey FOREIGN KEY (idrelatedname) REFERENCES relatedname(idrelatedname);


--
-- Name: taxonomicelementrelatedname_idtaxonomicelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelementrelatedname
    ADD CONSTRAINT taxonomicelementrelatedname_idtaxonomicelement_fkey FOREIGN KEY (idtaxonomicelement) REFERENCES taxonomicelement(idtaxonomicelement);


--
-- Name: taxonomicelements_ibfk_idclass; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idclass FOREIGN KEY (idclass) REFERENCES class(idclass);


--
-- Name: taxonomicelements_ibfk_idfamily; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idfamily FOREIGN KEY (idfamily) REFERENCES family(idfamily);


--
-- Name: taxonomicelements_ibfk_idgenus; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idgenus FOREIGN KEY (idgenus) REFERENCES genus(idgenus);


--
-- Name: taxonomicelements_ibfk_idinfraspecificepithet; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idinfraspecificepithet FOREIGN KEY (idinfraspecificepithet) REFERENCES infraspecificepithet(idinfraspecificepithet);


--
-- Name: taxonomicelements_ibfk_idkingdom; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idkingdom FOREIGN KEY (idkingdom) REFERENCES kingdom(idkingdom);


--
-- Name: taxonomicelements_ibfk_idmorphospecies; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idmorphospecies FOREIGN KEY (idmorphospecies) REFERENCES morphospecies(idmorphospecies);


--
-- Name: taxonomicelements_ibfk_idnomenclaturalcode; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idnomenclaturalcode FOREIGN KEY (idnomenclaturalcode) REFERENCES nomenclaturalcode(idnomenclaturalcode);


--
-- Name: taxonomicelements_ibfk_idorder; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idorder FOREIGN KEY (idorder) REFERENCES "order"(idorder);


--
-- Name: taxonomicelements_ibfk_idphylum; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idphylum FOREIGN KEY (idphylum) REFERENCES phylum(idphylum);


--
-- Name: taxonomicelements_ibfk_idscientificname; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idscientificname FOREIGN KEY (idscientificname) REFERENCES scientificname(idscientificname);


--
-- Name: taxonomicelements_ibfk_idscientificnameauthorship; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idscientificnameauthorship FOREIGN KEY (idscientificnameauthorship) REFERENCES scientificnameauthorship(idscientificnameauthorship);


--
-- Name: taxonomicelements_ibfk_idspecificepithet; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idspecificepithet FOREIGN KEY (idspecificepithet) REFERENCES specificepithet(idspecificepithet);


--
-- Name: taxonomicelements_ibfk_idtaxonrank; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelement
    ADD CONSTRAINT taxonomicelements_ibfk_idtaxonrank FOREIGN KEY (idtaxonrank) REFERENCES taxonrank(idtaxonrank);


--
-- Name: taxonomicelementsynonym_idsynonym_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelementsynonym
    ADD CONSTRAINT taxonomicelementsynonym_idsynonym_fkey FOREIGN KEY (idsynonym) REFERENCES synonym(idsynonym);


--
-- Name: taxonomicelementsynonym_idtaxonomicelement_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY taxonomicelementsynonym
    ADD CONSTRAINT taxonomicelementsynonym_idtaxonomicelement_fkey FOREIGN KEY (idtaxonomicelement) REFERENCES taxonomicelement(idtaxonomicelement);


--
-- Name: type_log_dq_log_dq_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_dq
    ADD CONSTRAINT type_log_dq_log_dq_fk FOREIGN KEY (id_type_log) REFERENCES type_log_dq(id);


--
-- Name: typestatuscuratorial_idcuratorialelements_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialtypestatus
    ADD CONSTRAINT typestatuscuratorial_idcuratorialelements_fkey FOREIGN KEY (idcuratorialelement) REFERENCES curatorialelement(idcuratorialelement);


--
-- Name: typestatuscuratorial_idtypestatus_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY curatorialtypestatus
    ADD CONSTRAINT typestatuscuratorial_idtypestatus_fkey FOREIGN KEY (idtypestatus) REFERENCES typestatus(idtypestatus);


--
-- Name: users_ibfk_idgroup; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_ibfk_idgroup FOREIGN KEY ("idGroup") REFERENCES groups("idGroup");


--
-- Name: users_log_dq_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_dq
    ADD CONSTRAINT users_log_dq_fk FOREIGN KEY (id_user) REFERENCES users("idUser");


--
-- Name: users_process_log_dq_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY process_log_dq
    ADD CONSTRAINT users_process_log_dq_fk FOREIGN KEY (id_user) REFERENCES users("idUser");


--
-- Name: wedf; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speciesidkey
    ADD CONSTRAINT wedf FOREIGN KEY (idreferenceelement) REFERENCES referenceelement(idreferenceelement) ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

