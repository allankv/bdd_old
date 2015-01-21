
<div style="position:relative;margin-left: auto;margin-right: auto;width:80%;margin-top:50px;text-align:left;">
    <h1><?php echo Yii::t('yii','About the Biodiversity Data Digitizer'); ?> - <b>BDD</b></h1>
        <p><?php echo Yii::t('yii','The Biodiversity Data Digitizer (BDD) is a tool designed for easy digitization, manipulation, and publication of biodiversity data. It stands out by allowing the user to manipulate its data simply and objectively, especially the data from field observations and small collections, which do not justify or demand the use of collection management software.'); ?></p>
    <br/><h3><?php echo Yii::t('yii','Standards'); ?></h3>
        <p><?php echo Yii::t('yii','BDD is based on the Darwin Core standard (DwC), published by TDWG, that is centered on taxa, their occurrence in nature as documented by observations, specimens, and samples, and related information. Standards such as the MRTG, currently submitted as TDWG standard, for collation, management and dissemination of multimedia resources relevant to biodiversity, and the Dublin Core, an interoperable metadata standard that supports a broad range of purposes and business models, are used to complement the DwC. Draft standards, developed for specific purposes, are also implemented as modules in BDD: interactions between specimens, environmental monitoring and pollination deficit.'); ?></p>
    <br/><h3><?php echo Yii::t('yii','Access tool'); ?></h3>
        <p><?php echo Yii::t('yii','The BDD is a browser-based system that can be accessed remotely, through an external server, or locally, when installed on a personal computer. Among its main features is the registration and handling (update, delete, and search) of species occurrences (specimens), following the Darwin Core, and of specimen interaction data, following the Interaction Extension. The data can be displayed on maps or table records and can be published to other systems with the TDWG Access Protocol for Information Retrieval (TAPIR).'); ?></p>
    <br/><h3><?php echo Yii::t('yii','Data quality'); ?></h3>
        <p><?php echo Yii::t('yii','The BDD helps users improve and maintain data quality. Where relevant, users are prompted by lists of suggested entries based on authoritative databases, such as the one obtained from the Integrated Taxonomic Information System (ITIS) for taxonomic names. When the user fills in a scientific name in the BDD, and this name is in the reference list or has already been registered, all other fields linked to it (kingdom, phylum, class, etc.) are automatically filled out, enhancing and completing the data record and decreasing the chance of entry errors. New features, always keeping in mind data quality, are being developed, such as user access control, validation of new records by key users, upload and publication of images and their metadata, a database of bibliographic references, and the ability to load data from spreadsheets.'); ?></p>
    <br/><h3><?php echo Yii::t('yii','Development'); ?></h3>
        <p><?php echo Yii::t('yii','The Biodiversity Data Digitizer was developed at the Polytechnic School in the University of São Paulo (Escola Politécnica da Universidade de São Paulo) in São Paulo, Brazil. It was created in partnership with the Inter-American Biodiversity Information Network (IABIN), the Food and Agriculture Organization of the United Nations (FAO), the Global Biodiversity Information Facility (GBIF), and the Instituto Nacional de Biodiversidad (INBio) of Costa Rica.'); ?></p>
        <br/><?php echo Yii::t('yii', 'The BDD was an outgrowth of the Pollinator Data Digitizer (PDD), which was developed within the scope of the Pollinator Thematic Network of IABIN. It is based on open source software, including PHP, PostgreSQL, and the Yii framework. For the future, it can evolve to accommodate the new Interaction Extension recent developed by FAO.'); ?>
</div> 

<br/><br/><br/>