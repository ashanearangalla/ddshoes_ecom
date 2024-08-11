namespace ddApp.Models
{
    public class Partner
    {
        public int PartnerID { get; set; }
        public string PartnerName { get; set; }
        public string ContactEmail { get; set; }
        public string ContactPhone { get; set; }

 
        public int UserID { get; set; }
        public User User { get; set; }


        public ICollection<SubStock> StockDetails { get; set; }
    }
}
