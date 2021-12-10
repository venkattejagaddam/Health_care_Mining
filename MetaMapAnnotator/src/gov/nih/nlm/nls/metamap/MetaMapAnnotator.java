
package gov.nih.nlm.nls.metamap;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintStream;
import java.io.Reader;
import java.util.ArrayList;
import java.util.Map;
import java.util.HashMap;
import java.util.List;
import java.util.Properties;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.apache.commons.csv.CSVFormat;
import org.apache.commons.csv.CSVPrinter;
import org.apache.commons.csv.CSVRecord;


public class MetaMapAnnotator {

    private static Properties configProp = new Properties();

    // String Constants
    private static final String EMPTY_STRING = "";
    private static final String PATH_TO_RESOURCES = "./resources/";

    MetaMapApi api;
    private static List<String> ignoredWords = new ArrayList<String>();
    private static List<String> includePOSTags = new ArrayList<String>();

    /**
     * Creates new instance with the given mmserver config details
     *
     * @param serverhost the value of server host
     * @param serverport the value of server port
     */
    public MetaMapAnnotator(String serverhost, int serverport) {
        this.api = new MetaMapApiImpl();
        this.api.setHost(serverhost);
        this.api.setPort(serverport);
    }

    /**
     * Creates new instance of the MetaMap API
     *
     */
    public MetaMapAnnotator() {
        this.api = new MetaMapApiImpl();
    }

    /**
     * Entry point for the MetaMap Annotator program execution
     *
     * @param args the command line arguments
     */
    public static void main(String[] args) {

        try {
            init();
            System.out.println("------Process Started------");
            processWebUserPostData();
            System.out.println("-------Process Completed------");
        } catch (Exception ex) {
            Logger.getLogger(MetaMapAnnotator.class.getName()).log(Level.SEVERE, ex.getMessage(), ex);
        }

    }

    /**
     * Load the initial setup and config data
     *
     * @throws IOException
     */
    private static void init() throws IOException {
        File configFile = new File(PATH_TO_RESOURCES + "MetaMapAnnotatorConfig.properties");
        FileInputStream configStream = new FileInputStream(configFile);
        configProp.load(configStream);
        populateIgnoredWordsList();
        populatePOSTags();
    }

    /**
     * Populate the words to be ignored from the CSV file into a list
     *
     */
    private static void populateIgnoredWordsList() {
        Reader in = null;
        try {
            File file = new File(PATH_TO_RESOURCES + configProp.getProperty("ignored_words_file_name"));
            in = new FileReader(file);
            Iterable<CSVRecord> records = CSVFormat.RFC4180.withFirstRecordAsHeader().parse(in);
            for (CSVRecord record : records) {
                ignoredWords.add(record.get(0));
            }
        } catch (FileNotFoundException ex) {
            Logger.getLogger(MetaMapAnnotator.class.getName()).log(Level.SEVERE, null, ex);
        } catch (IOException ex) {
            Logger.getLogger(MetaMapAnnotator.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            try {
                if (in != null) {
                    in.close();
                }
            } catch (IOException ex) {
                Logger.getLogger(MetaMapAnnotator.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    /**
     * Populate the POS tags to be included from the CSV file into a list
     *
     */
    private static void populatePOSTags() {
        Reader in = null;
        try {
            File file = new File(PATH_TO_RESOURCES + configProp.getProperty("include_pos_tags_file_name"));
            in = new FileReader(file);
            Iterable<CSVRecord> records = CSVFormat.RFC4180.withFirstRecordAsHeader().parse(in);
            for (CSVRecord record : records) {
                includePOSTags.add(record.get(0));
            }
        } catch (FileNotFoundException ex) {
            Logger.getLogger(MetaMapAnnotator.class.getName()).log(Level.SEVERE, null, ex);
        } catch (IOException ex) {
            Logger.getLogger(MetaMapAnnotator.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            try {
                if (in != null) {
                    in.close();
                }
            } catch (IOException ex) {
                Logger.getLogger(MetaMapAnnotator.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    /**
     * Set the timeout
     *
     * @param interval
     */
    private void setTimeout(int interval) {
        this.api.setTimeout(interval);
    }

    /**
     * Reads from CSV file and triggers the MetaMap annotator for each post
     *
     * @throws FileNotFoundException
     * @throws IOException
     * @throws Exception
     */
    private static void processWebUserPostData() throws FileNotFoundException, IOException, Exception {
        File dir = new File(configProp.getProperty("web_scraper_csv_folder"));
                String serverhost = MetaMapApi.DEFAULT_SERVER_HOST;
        int serverport = MetaMapApi.DEFAULT_SERVER_PORT;
        int timeout = -1;

        PrintStream output = System.out;
        MetaMapAnnotator frontEnd = new MetaMapAnnotator(serverhost, serverport);
        List<String> options = new ArrayList<>();
        options.add("-y");  // Use word sense disambiguation https://metamap.nlm.nih.gov/Docs/FAQ/WSD.pdf Adds overhead to processing
        options.add("--restrict_to_sts");   // Retain only Concepts with Specified Semantic Types. https://metamap.nlm.nih.gov/SemanticTypesAndGroups.shtml
        options.add("dsyn,sosy,topp,clnd,bpoc");
        options.add("--unique_acros_abbrs_only");   // Restricts the generation of acronym/abbreviation (AA) variants to those forms with unique expansions.
        options.add("--no_derivational_variants");  // Prevents the use of any derivational variation in the computation of word variants. This option exists because derivational variants can involve a significant change in meaning.
        options.add("--TAGGER_SERVER");
        options.add("localhost");
        //disable below option if slow
        options.add("--composite_phrases");
        options.add("4");

        if (timeout > -1) {
            frontEnd.setTimeout(timeout);
        }
        File[] csvFilesList = dir.listFiles((File directory, String filename) -> filename.endsWith(".csv"));
        for (File file : csvFilesList) {
            Reader in = new FileReader(file);
            Iterable<CSVRecord> records = CSVFormat.RFC4180.withFirstRecordAsHeader().parse(in);
            String outputFile = PATH_TO_RESOURCES + file.getName();
            CSVFormat csvFileFormat = CSVFormat.EXCEL.withHeader("PostNumber", "SymptomId", "SymptomName", "TreatmentId", "TreatmentName", "DrugId", "DrugName", "BodypartId", "BodypartName","PostLink");
            CSVPrinter csvFilePrinter;
            try (FileWriter fileWriter = new FileWriter(outputFile)) {
                csvFilePrinter = new CSVPrinter(fileWriter, csvFileFormat);
                for (CSVRecord record : records) {
                    long recordNumber = record.getRecordNumber();
                    
                    String postLink = record.get(0);
                    String postHeading = record.get(1);
                    String postContent = record.get(3);
                    String postReplies = record.get(4);

                    //clean off non ASCII characters
                    postHeading = stripNonASCII(postHeading);
                    postContent = stripNonASCII(postContent);
                    postReplies = stripNonASCII(postReplies);
                    
                    
                    String addedContent = postContent.concat(postReplies);

                    System.out.println("----------------------------------------------------");
                    triggerMetaMap(frontEnd, output, options, csvFilePrinter, recordNumber, postHeading, addedContent,postLink);
                    System.out.println("----------------------------------------------------");
                    System.out.println("Record Number " +recordNumber+ " Parsing Completed");
                }
                fileWriter.flush();
            }
            csvFilePrinter.close();
        }
        
        frontEnd.api.disconnect();

    }

    /**
     * Removes all non ASCII characters from the inputText, trims and returns
     * the given string.
     *
     * @param inputText
     *
     * @return
     */
    private static String stripNonASCII(String inputText) {
        String result = inputText;
        result = result.replaceAll("[^\\x00-\\x7F]", EMPTY_STRING);
        result = result.replaceAll("[\\p{Cntrl}&&[^\r\n\t]]", EMPTY_STRING);
        result = result.replaceAll("\\p{C}", EMPTY_STRING);
        result = result.trim();
        return result;
    }

    /**
     * Triggers the MetaMap API with the given text content. Throws an Exception
     * if the MetaMap server is not running.
     *
     * @param category
     * @param postHeading
     * @param postContent
     *
     * @throws Exception
     */
    private static void triggerMetaMap(MetaMapAnnotator mmFrontEnd, PrintStream output,List<String> options, CSVPrinter csvFilePrinter, long recordNumber,  String postHeading, String postContent,String postLink) throws Exception {

        if (!"".equals(postContent)) {
            mmFrontEnd.process(csvFilePrinter, recordNumber, postContent, output, options,postLink);
        }
    }

    /**
     * Triggers the MetaMap annotator for the given text content and prints the
     * output to the given out print stream.
     *
     * @param terms
     * @param out
     * @param serverOptions
     *
     * @throws Exception
     */
    private void process(CSVPrinter csvFilePrinter, long recordNumber, String terms, PrintStream out, List<String> serverOptions,String postLink) throws Exception {
        if (serverOptions.size() > 0) {
            api.setOptions(serverOptions);
        }
        HashMap<String, String> diseaseDict = new HashMap<>();
        HashMap<String, String> symptomDict = new HashMap<>();
        HashMap<String, String> treatmentDict = new HashMap<>();
        HashMap<String, String> drugsDict = new HashMap<>();
        HashMap<String, String> bodyPartDict = new HashMap<>();

        List<Result> resultList = api.processCitationsFromString(terms);

        for (Result result : resultList) {
            if (result != null) {
                for (Utterance utterance : result.getUtteranceList()) {
                    for (PCM pcm : utterance.getPCMList()) {
                        for (Mapping map : pcm.getMappingList()) {
                            for (Ev mapEv : map.getEvList()) {
                                boolean filterOut = false;
                                for (String ignoreWord : ignoredWords) { 
                                    for (String matchedWord : mapEv.getMatchedWords()) {
                                        if (matchedWord.toLowerCase().equals(ignoreWord.toLowerCase())) {
                                            if (mapEv.getMatchedWords().size() == 1) {
                                                filterOut = true;
                                            }
                                        }
                                    }
                                  } 

                                if (!filterOut) {
//                                out.println("   Score: " + mapEv.getScore());
                                	out.println(" Phrase: " + pcm.getPhrase().getPhraseText());		// Shivani
                                	out.println("  Mappings:");										// Shivani
                                    out.println("   Filter Status: " + filterOut);
                                    out.println("   Concept Id: " + mapEv.getConceptId());
                                    out.println("   Concept Name: " + mapEv.getConceptName());
                                    out.println("   Preferred Name: " + mapEv.getPreferredName());
                                    out.println("   Matched Words: " + mapEv.getMatchedWords());
                                    out.println("   Semantic Types: " + mapEv.getSemanticTypes());

                                    String diseaseName = EMPTY_STRING, symptomName = EMPTY_STRING, diseaseId = EMPTY_STRING, symptomId = EMPTY_STRING, treatmentName = EMPTY_STRING, treatmentId = EMPTY_STRING, drugName = EMPTY_STRING, drugId = EMPTY_STRING, bodyPartName = EMPTY_STRING, bodypartId = EMPTY_STRING;
                                    if (mapEv.getSemanticTypes().contains("dsyn")) {
                                        diseaseName = mapEv.getPreferredName();
                                        diseaseId = mapEv.getConceptId();
                                        diseaseDict.put(diseaseId, diseaseName);
                                    }
                                    if (mapEv.getSemanticTypes().contains("sosy")) {
                                        symptomName = mapEv.getPreferredName();
                                        symptomId = mapEv.getConceptId();
                                        symptomDict.put(symptomId, symptomName);
                                    }
                                    if (mapEv.getSemanticTypes().contains("topp")) {
                                        treatmentName = mapEv.getPreferredName();
                                        treatmentId = mapEv.getConceptId();
                                        treatmentDict.put(treatmentId, treatmentName);
                                    }
                                    if (mapEv.getSemanticTypes().contains("clnd")) {
                                        drugName = mapEv.getPreferredName();
                                        drugId = mapEv.getConceptId();
                                        drugsDict.put(drugId, drugName);
                                    }
                                    if (mapEv.getSemanticTypes().contains("bpoc")) {
                                        bodyPartName = mapEv.getPreferredName();
                                        bodypartId = mapEv.getConceptId();
                                        bodyPartDict.put(bodypartId, bodyPartName);

                                    }
                                }
                            }
                        }
                    }
                }

            } else {
                out.println("The result instance is NULL!");
            }
        }

        
        for (Map.Entry<String, String> entry : diseaseDict.entrySet()) {
            csvFilePrinter.printRecord(recordNumber, entry.getKey(), entry.getValue(), EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING,postLink);
        }
        for (Map.Entry<String, String> entry : symptomDict.entrySet()) {
            csvFilePrinter.printRecord(recordNumber, entry.getKey(), entry.getValue(), EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING,postLink);
        }
        for (Map.Entry<String, String> entry : treatmentDict.entrySet()) {
            csvFilePrinter.printRecord(recordNumber, EMPTY_STRING, EMPTY_STRING, entry.getKey(), entry.getValue(), EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING,postLink);
        }
        for (Map.Entry<String, String> entry : drugsDict.entrySet()) {
            csvFilePrinter.printRecord(recordNumber, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, entry.getKey(), entry.getValue(), EMPTY_STRING, EMPTY_STRING,postLink);
        }
        for (Map.Entry<String, String> entry : bodyPartDict.entrySet()) {
            csvFilePrinter.printRecord(recordNumber, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, EMPTY_STRING, entry.getKey(), entry.getValue(),postLink);
        }
        this.api.resetOptions();
    }
}
