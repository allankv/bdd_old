<?php

class ProviderLogic {
    public function performSQLMedia() {
        $c = array();
        $rs = array();
        
        
        // Use this set of SQL commands for the regular database
        // With schema
        /*$c['select'] = "select
        '<Record>\n' ||
        '<id>' || idmedia || '</id>\n' ||
        '<dcterms:title>' || coalesce(media.title, '') || '</dcterms:title>\n' ||
        '<mrtg:caption>' || coalesce(media.caption, '') || '</mrtg:caption>\n' ||
        '<dcterms:type>' || coalesce(typemedia.typemedia, '') || '</dcterms:type>\n' ||
        '<mrtg:subtype>' || coalesce(subtypemedia.subtype, '') || '</mrtg:subtype>\n' ||
        '<category>' || coalesce(categorymedia.categorymedia, '') || '</category>\n' ||
        '<subcategory>' || coalesce(subcategorymedia.subcategorymedia, '') || '</subcategory>\n' ||
        '<dcterms:extent>' || coalesce(extent, '') || '</dcterms:extent>\n' ||
        '<dcterms:language>' || coalesce(language, '') || '</dcterms:language>\n' ||
        '<mrtg:metadataProvider>' || coalesce(metadataprovider, '') || '</mrtg:metadataProvider>\n' ||
        '<mrtg:description>' || coalesce(description, '') || '</mrtg:description>\n' ||
        '<mrtg:copyrightOwner>' || coalesce(copyrightowner, '') || '</mrtg:copyrightOwner>\n' ||
        '<mrtg:accessURL>' || coalesce(NULLIF(accessURL, ''), 'http://bdd.pcs.usp.br/iabinptn/' || path || '/' || filesystemname, '') || '</mrtg:accessURL>\n'
        '<mrtg:comments>' || coalesce(comment, '') || '</mrtg:comments>\n' ||
        '</Record>\n' as xml ";*/

        //Without schema
        $c['select'] = "select
        '<Record>\n' ||
        '<id>' || idmedia || '</id>\n' ||
        '<title>' || replace(replace(coalesce(media.title, ''), '>', '&gt;'), '<', '&lt;') || '</title>\n' ||
        '<caption>' || replace(replace(coalesce(media.caption, ''), '>', '&gt;'), '<', '&lt;') || '</caption>\n' ||
        '<type>' || replace(replace(coalesce(typemedia.typemedia, ''), '>', '&gt;'), '<', '&lt;') || '</type>\n' ||
        '<subtype>' || replace(replace(coalesce(subtypemedia.subtype, ''), '>', '&gt;'), '<', '&lt;') || '</subtype>\n' ||
        '<category>' || replace(replace(coalesce(categorymedia.categorymedia, ''), '>', '&gt;'), '<', '&lt;') || '</category>\n' ||
        '<subcategory>' || replace(replace(coalesce(subcategorymedia.subcategorymedia, ''), '>', '&gt;'), '<', '&lt;') || '</subcategory>\n' ||
        '<extent>' || replace(replace(coalesce(extent, ''), '>', '&gt;'), '<', '&lt;') || '</extent>\n' ||
        '<language>' || replace(replace(coalesce(language, ''), '>', '&gt;'), '<', '&lt;') || '</language>\n' ||
        '<metadataProvider>' || replace(replace(coalesce(metadataprovider, ''), '>', '&gt;'), '<', '&lt;') || '</metadataProvider>\n' ||
        '<description>' || replace(replace(coalesce(description, ''), '>', '&gt;'), '<', '&lt;') || '</description>\n' ||
        '<copyrightOwner>' || replace(replace(coalesce(copyrightowner, ''), '>', '&gt;'), '<', '&lt;') || '</copyrightOwner>\n' ||
        '<accessURL>' || replace(replace(coalesce(NULLIF(accessURL, ''), 'http://bdd.pcs.usp.br/iabinptn/' || path || '/' || filesystemname, ''), '>', '&gt;'), '<', '&lt;') || '</accessURL>\n'
        '<comments>' || replace(replace(coalesce(comment, ''), '>', '&gt;'), '<', '&lt;') || '</comments>\n' ||
        '</Record>\n' as xml ";

        $c['from'] = ' FROM media ';
        $c['join'] = $c['join'].' LEFT JOIN typemedia on media.idtypemedia = typemedia.idtypemedia ';
        $c['join'] = $c['join'].' LEFT JOIN subtype subtypemedia on media.idsubtype = subtypemedia.idsubtype ';
        $c['join'] = $c['join'].' LEFT JOIN categorymedia on media.idcategorymedia = categorymedia.idcategorymedia ';
        $c['join'] = $c['join'].' LEFT JOIN subcategorymedia on media.idsubcategorymedia = subcategorymedia.idsubcategorymedia ';
        $c['join'] = $c['join'].' LEFT JOIN language on media.idlanguage = language.idlanguage ';
        //$c['join'] = $c['join'].' LEFT JOIN creators on media.idcreators = creators.idcreators ';
        $c['join'] = $c['join'].' LEFT JOIN metadataprovider on media.idmetadataprovider = metadataprovider.idmetadataprovider ';
        $c['join'] = $c['join'].' LEFT JOIN file on media.idfile = file.idfile ';
        $c['where'] = ' WHERE media.isrestricted = FALSE ';
        //$c['orderby'] = ' ORDER BY scn.scientificname, sp.idspecies ';
        //$c['limit'] = ' limit '.$filter['limit'];
        //$c['offset'] = ' offset '.$filter['offset'];



        // Use this set of SQL commands for the iabinptn database
        //With schema
        /*$c['select'] = "select
        '<Record>\n' ||
        '<id>' || idmedia || '</id>\n' ||
        '<dcterms:title>' || coalesce(media.title, '') || '</dcterms:title>\n' ||
        '<mrtg:caption>' || coalesce(media.caption, '') || '</mrtg:caption>\n' ||
        '<dcterms:type>' || coalesce(typemedia.typemedia, '') || '</dcterms:type>\n' ||
        '<mrtg:subtype>' || coalesce(subtypemedia.subtype, '') || '</mrtg:subtype>\n' ||
        '<category>' || coalesce(categorymedia.categorymedia, '') || '</category>\n' ||
        '<subcategory>' || coalesce(subcategorymedia.subcategorymedia, '') || '</subcategory>\n' ||
        '<dcterms:extent>' || coalesce(extent, '') || '</dcterms:extent>\n' ||
        '<dcterms:language>' || coalesce(language, '') || '</dcterms:language>\n' ||
        '<mrtg:metadataProvider>' || coalesce(metadataprovider, '') || '</mrtg:metadataProvider>\n' ||
        '<mrtg:description>' || coalesce(description, '') || '</mrtg:description>\n' ||
        '<dcterms:creator>' || coalesce(creators, '') || '</dcterms:creator>\n' ||
        '<mrtg:copyrightOwner>' || coalesce(copyrightowner, '') || '</mrtg:copyrightOwner>\n' ||
        '<mrtg:accessURL>' || coalesce(NULLIF(accessURL, ''), 'http://bdd.pcs.usp.br/iabinptn/' || path || '/' || filesystemname, '') || '</mrtg:accessURL>\n'
        '<mrtg:comments>' || coalesce(comments, '') || '</mrtg:comments>\n' ||
        '</Record>\n' as xml ";*/

        //Without schema
        /*$c['select'] = "select
        '<Record>\n' ||
        '<id>' || idmedia || '</id>\n' ||
        '<title>' || replace(replace(coalesce(media.title, ''), '>', '&gt;'), '<', '&lt;') || '</title>\n' ||
        '<caption>' || replace(replace(coalesce(media.caption, ''), '>', '&gt;'), '<', '&lt;') || '</caption>\n' ||
        '<type>' || replace(replace(coalesce(typemedia.typemedia, ''), '>', '&gt;'), '<', '&lt;') || '</type>\n' ||
        '<subtype>' || replace(replace(coalesce(subtypemedia.subtype, ''), '>', '&gt;'), '<', '&lt;') || '</subtype>\n' ||
        '<category>' || replace(replace(coalesce(categorymedia.categorymedia, ''), '>', '&gt;'), '<', '&lt;') || '</category>\n' ||
        '<subcategory>' || replace(replace(coalesce(subcategorymedia.subcategorymedia, ''), '>', '&gt;'), '<', '&lt;') || '</subcategory>\n' ||
        '<extent>' || replace(replace(coalesce(extent, ''), '>', '&gt;'), '<', '&lt;') || '</extent>\n' ||
        '<language>' || replace(replace(coalesce(language, ''), '>', '&gt;'), '<', '&lt;') || '</language>\n' ||
        '<metadataProvider>' || replace(replace(coalesce(metadataprovider, ''), '>', '&gt;'), '<', '&lt;') || '</metadataProvider>\n' ||
        '<description>' || replace(replace(coalesce(description, ''), '>', '&gt;'), '<', '&lt;') || '</description>\n' ||
        '<creator>' || replace(replace(coalesce(creators, ''), '>', '&gt;'), '<', '&lt;') || '</creator>\n' ||
        '<copyrightOwner>' || replace(replace(coalesce(copyrightowner, ''), '>', '&gt;'), '<', '&lt;') || '</copyrightOwner>\n' ||
        '<accessURL>' || replace(replace(coalesce(NULLIF(accessURL, ''), 'http://bdd.pcs.usp.br/iabinptn/' || path || '/' || filesystemname, ''), '>', '&gt;'), '<', '&lt;') || '</accessURL>\n'
        '<comments>' || replace(replace(coalesce(comments, ''), '>', '&gt;'), '<', '&lt;') || '</comments>\n' ||
        '</Record>\n' as xml ";*/

        /*$c['from'] = ' FROM media ';
        $c['join'] = $c['join'].' LEFT JOIN typemedia on media.idtypemedia = typemedia.idtypemedia ';
        $c['join'] = $c['join'].' LEFT JOIN subtype subtypemedia on media.idsubtype = subtypemedia.idsubtype ';
        $c['join'] = $c['join'].' LEFT JOIN categorymedia on media.idcategorymedia = categorymedia.idcategorymedia ';
        $c['join'] = $c['join'].' LEFT JOIN subcategorymedia on media.idsubcategorymedia = subcategorymedia.idsubcategorymedia ';
        $c['join'] = $c['join'].' LEFT JOIN languages on media.idlanguages = languages.idlanguages ';
        $c['join'] = $c['join'].' LEFT JOIN creators on media.idcreators = creators.idcreators ';
        $c['join'] = $c['join'].' LEFT JOIN metadataprovider on media.idmetadataprovider = metadataprovider.idmetadataprovider ';
        $c['join'] = $c['join'].' LEFT JOIN files on media.idfile = files.idfile ';
        $c['where'] = ' WHERE media.isrestricted = FALSE ';
        //$c['orderby'] = ' ORDER BY scn.scientificname, sp.idspecies ';
        //$c['limit'] = ' limit '.$filter['limit'];
        //$c['offset'] = ' offset '.$filter['offset'];*/

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];//.$c['orderby'].$c['limit'].$c['offset'];
        $rs['sql'] = $sql;
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function performSQLRef() {
        $c = array();
        $rs = array();

        // Use this set of SQL commands for the regular database
        //With schema
        /*$c['select'] = "select
        '<Record>\n' ||
        '<id>' || idreferenceelement || '</id>\n' ||
        '<dcterms:title>' || coalesce(title, '') || '</dcterms:title>\n' ||
        '<dcterms:subject>' || coalesce(subject, '') || '</dcterms:subject>\n' ||
        '<dcterms:type>' || coalesce(type.typereference, '') || '</dcterms:type>\n' ||
        '<mrtg:subtype>' || coalesce(subtype.subtypereference, '') || '</mrtg:subtype>\n' ||
        '<category>' || coalesce(category.categoryreference, '') || '</category>\n' ||
        '<subcategory>' || coalesce(subcategory.subcategoryreference, '') || '</subcategory>\n' ||
        '<dcterms:language>' || coalesce(language, '') || '</dcterms:language>\n' ||
        '<mrtg:description>' || coalesce(description, '') || '</mrtg:description>\n' ||
        '<dcterms:source>' || coalesce(source, '') || '</dcterms:source>\n' ||
        '<dcterms:bibligraphicCitation>' || coalesce(bibliographiccitation, '') || '</dcterms:bibligraphicCitation>\n' ||
        '<mrtg:accessURL>' || coalesce(NULLIF(\"URI\", ''), 'http://bdd.pcs.usp.br/iabinptn/' || path || '/' || filesystemname, '') || '</mrtg:accessURL>\n' ||
        '</Record>\n' as xml ";*/

        //Without schema
        $c['select'] = "select
        '<Record>\n' ||
        '<id>' || idreferenceelement || '</id>\n' ||
        '<title>' || replace(replace(coalesce(title, ''), '>', '&gt;'), '<', '&lt;') || '</title>\n' ||
        '<subject>' || replace(replace(coalesce(subject, ''), '>', '&gt;'), '<', '&lt;') || '</subject>\n' ||
        '<type>' || replace(replace(coalesce(type.typereference, ''), '>', '&gt;'), '<', '&lt;') || '</type>\n' ||
        '<subtype>' || replace(replace(coalesce(subtype.subtypereference, ''), '>', '&gt;'), '<', '&lt;') || '</subtype>\n' ||
        '<category>' || replace(replace(coalesce(category.categoryreference, ''), '>', '&gt;'), '<', '&lt;') || '</category>\n' ||
        '<subcategory>' || replace(replace(coalesce(subcategory.subcategoryreference, ''), '>', '&gt;'), '<', '&lt;') || '</subcategory>\n' ||
        '<language>' || replace(replace(coalesce(language, ''), '>', '&gt;'), '<', '&lt;') || '</language>\n' ||
        '<description>' || replace(replace(coalesce(description, ''), '>', '&gt;'), '<', '&lt;') || '</description>\n' ||
        '<source>' || replace(replace(coalesce(source, ''), '>', '&gt;'), '<', '&lt;') || '</source>\n' ||
        '<bibligraphicCitation>' || replace(replace(coalesce(bibliographiccitation, ''), '>', '&gt;'), '<', '&lt;') || '</bibligraphicCitation>\n' ||
        '<accessURL>' || replace(replace(coalesce(NULLIF(\"URI\", ''), 'http://bdd.pcs.usp.br/iabinptn/' || path || '/' || filesystemname, ''), '>', '&gt;'), '<', '&lt;') || '</accessURL>\n' ||
        '</Record>\n' as xml ";

        $c['from'] = ' FROM referenceelement as ref ';
        $c['join'] = $c['join'].' LEFT JOIN typereference type on ref.idtypereference = type.idtypereference ';
        $c['join'] = $c['join'].' LEFT JOIN subtypereference subtype on ref.idsubtypereference = subtype.idsubtypereference ';
        $c['join'] = $c['join'].' LEFT JOIN categoryreference category on ref.idcategoryreference = category.idcategoryreference ';
        $c['join'] = $c['join'].' LEFT JOIN subcategoryreference subcategory on ref.idsubcategoryreference = subcategory.idsubcategoryreference ';
        $c['join'] = $c['join'].' LEFT JOIN language on ref.idlanguage = language.idlanguage ';
        //$c['join'] = $c['join'].' LEFT JOIN creators on ref.idcreators = creators.idcreators ';
        $c['join'] = $c['join'].' LEFT JOIN file on ref.idfile = file.idfile ';
        $c['where'] = ' WHERE ref.isrestricted = FALSE ';
        //$c['orderby'] = ' ORDER BY scn.scientificname, sp.idspecies ';
        //$c['limit'] = ' limit '.$filter['limit'];
        //$c['offset'] = ' offset '.$filter['offset'];



        //Use this set of SQL commands for the iabinptn database
        //With schema
        /*$c['select'] = "select
        '<Record>\n' ||
        '<id>' || idreferenceselements || '</id>\n' ||
        '<dcterms:title>' || coalesce(title, '') || '</dcterms:title>\n' ||
        '<dcterms:subject>' || coalesce(subject, '') || '</dcterms:subject>\n' ||
        '<dcterms:type>' || coalesce(type.typereferences, '') || '</dcterms:type>\n' ||
        '<mrtg:subtype>' || coalesce(subtype.subtypereferences, '') || '</mrtg:subtype>\n' ||
        '<category>' || coalesce(category.categoryreferences, '') || '</category>\n' ||
        '<subcategory>' || coalesce(subcategory.subcategoryreferences, '') || '</subcategory>\n' ||
        '<dcterms:language>' || coalesce(language, '') || '</dcterms:language>\n' ||
        '<mrtg:description>' || coalesce(description, '') || '</mrtg:description>\n' ||
        '<dcterms:creator>' || coalesce(creators, '') || '</dcterms:creator>\n' ||
        '<dcterms:source>' || coalesce(source, '') || '</dcterms:source>\n' ||
        '<dcterms:bibligraphicCitation>' || coalesce(bibliographiccitation, '') || '</dcterms:bibligraphicCitation>\n' ||
        '<mrtg:accessURL>' || coalesce(NULLIF(\"URI\", ''), 'http://bdd.pcs.usp.br/iabinptn/' || path || '/' || filesystemname, '') || '</mrtg:accessURL>\n' ||
        '</Record>\n' as xml "; */

        //Without schema
        /*$c['select'] = "select
        '<Record>\n' ||
        '<id>' || idreferenceselements || '</id>\n' ||
        '<title>' || replace(replace(coalesce(title, ''), '>', '&gt;'), '<', '&lt;') || '</title>\n' ||
        '<subject>' || replace(replace(coalesce(subject, ''), '>', '&gt;'), '<', '&lt;') || '</subject>\n' ||
        '<type>' || replace(replace(coalesce(type.typereferences, ''), '>', '&gt;'), '<', '&lt;') || '</type>\n' ||
        '<subtype>' || replace(replace(coalesce(subtype.subtypereferences, ''), '>', '&gt;'), '<', '&lt;') || '</subtype>\n' ||
        '<category>' || replace(replace(coalesce(category.categoryreferences, ''), '>', '&gt;'), '<', '&lt;') || '</category>\n' ||
        '<subcategory>' || replace(replace(coalesce(subcategory.subcategoryreferences, ''), '>', '&gt;'), '<', '&lt;') || '</subcategory>\n' ||
        '<language>' || replace(replace(coalesce(language, ''), '>', '&gt;'), '<', '&lt;') || '</language>\n' ||
        '<description>' || replace(replace(coalesce(description, ''), '>', '&gt;'), '<', '&lt;') || '</description>\n' ||
        '<creator>' || replace(replace(coalesce(creators, ''), '>', '&gt;'), '<', '&lt;') || '</creator>\n' ||
        '<source>' || replace(replace(coalesce(source, ''), '>', '&gt;'), '<', '&lt;') || '</source>\n' ||
        '<bibligraphicCitation>' || replace(replace(coalesce(bibliographiccitation, ''), '>', '&gt;'), '<', '&lt;') || '</bibligraphicCitation>\n' ||
        '<accessURL>' || replace(replace(coalesce(NULLIF(\"URI\", ''), 'http://bdd.pcs.usp.br/iabinptn/' || path || '/' || filesystemname, ''), '>', '&gt;'), '<', '&lt;') || '</accessURL>\n' ||
        '</Record>\n' as xml ";*/

        /*$c['from'] = ' FROM referenceselements as ref ';
        $c['join'] = $c['join'].' LEFT JOIN typereferences type on ref.idtypereferences = type.idtypereferences ';
        $c['join'] = $c['join'].' LEFT JOIN subtypereferences subtype on ref.idsubtypereferences = subtype.idsubtypereferences ';
        $c['join'] = $c['join'].' LEFT JOIN categoryreferences category on ref.idcategoryreferences = category.idcategoryreferences ';
        $c['join'] = $c['join'].' LEFT JOIN subcategoryreferences subcategory on ref.idsubcategoryreferences = subcategory.idsubcategoryreferences ';
        $c['join'] = $c['join'].' LEFT JOIN languages on ref.idlanguages = languages.idlanguages ';
        $c['join'] = $c['join'].' LEFT JOIN creators on ref.idcreators = creators.idcreators ';
        $c['join'] = $c['join'].' LEFT JOIN files on ref.idfile = files.idfile ';
        $c['where'] = ' WHERE ref.isrestricted = FALSE ';
        //$c['orderby'] = ' ORDER BY scn.scientificname, sp.idspecies ';
        //$c['limit'] = ' limit '.$filter['limit'];
        //$c['offset'] = ' offset '.$filter['offset'];*/

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];//.$c['orderby'].$c['limit'].$c['offset'];
        $rs['sql'] = $sql;
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
}
?>
