import scrapy

from ..items import ScraperItem


class MedHelpSpider(scrapy.Spider):

    name = "medhelp"

    def start_requests(self):

        url = "https://www.medhelp.org/forums/Coronavirus/show/2203?page=1"
        yield scrapy.Request(url=url, callback=self.parse)

    def parse(self, response):
        list_entry = response.xpath("//div[@class = 'subject_list_ctn']")
        for list_entries in list_entry:
            entry = list_entries.xpath("//div[@class = 'subj_entry']")
            for entries in entry:
            	#Extract Title
                title = entries.xpath(".//h2/a/text()").get()
                #Extract URL
                url_link = entries.xpath(".//h2/a/@href").get()
                url_link = response.urljoin(url_link)
                yield scrapy.Request(url=url_link, callback=self.parse_url)
        page_nav = response.xpath("//a[@class = 'page_nav']")
        for page_navs in page_nav:
            next_page = page_navs.xpath(".//@href").get()
            next_pg_link = "https://www.medhelp.org" + next_page
            yield scrapy.Request(url=next_pg_link, callback=self.parse)

    def parse_url(self, response):
        items = ScraperItem()
        #Extract Post Content
        subject_msg = response.xpath("//div[@id = 'subject_msg']/text()").extract()
        seperator = ''
        content = seperator.join(subject_msg)
        content = content.strip()
        content = " ".join(content.split())
        
        title_link = response.url
        
        titles = response.xpath("//div[@class = 'subj_info']/h1/text()").get()
        titles = titles.strip()
        titles = " ".join(titles.split())
        
        author = response.xpath("//div[@class = 'username']/a/@href").get()
        author = author.strip()
        author = " ".join(author.split())
        
        items['url'] = title_link
        items['title'] = titles
        items['author'] = author
        items['content'] = content
        
        replies =[]
        post_itr = response.xpath("//div[@id ='post_show_content']")
        for posts in post_itr:
            response_itrs = posts.xpath("//div[@itemprop = 'suggestedAnswer']")
            for response_itr in response_itrs:
            	#Extract Reply
                responses = response_itr.xpath(".//div[@class = 'resp_body ']/text()").extract()
                responses = seperator.join(responses)
                responses = responses.strip()
                responses = " ".join(responses.split())
                
                sub_reply_content = {}
                sub_reply_content['content'] = responses
                
                #Extract Sub Replies
                comment_list = response_itr.xpath(".//div[@class ='comment_list']")
                sub_replies =[]
                for comment in comment_list:
                	sub_reply = comment.xpath(".//div[@class ='comment_body ']/text()").extract()
                	reply = [s.strip() for s in sub_reply]
                	sub_replies.append(reply)
                sub_reply_content['sub_replies'] = sub_replies
                replies.append(sub_reply_content)
        items['replies']=replies

        yield items
