# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: https://docs.scrapy.org/en/latest/topics/item-pipeline.html



import json

from  scrapy.exporters import JsonItemExporter

class JsonWriterPipeline(object):
    def __init__(self):
        self.file = open("G03_MedHelp.json", 'wb')
        self.exporter = JsonItemExporter(self.file, ensure_ascii=False,indent=4)
        self.exporter.start_exporting()

    def close_spider(self, spider):
        self.exporter.finish_exporting()
        self.file.close()

    def process_item(self, item, spider):
        self.exporter.export_item(item)
        return item