namespace ddApp.Dto
{
    public class PartnerDto
    {
        public int PartnerID { get; set; }
        public string PartnerName { get; set; }
        public string ContactEmail { get; set; }
        public string ContactPhone { get; set; }

        // Foreign key to User
        public int UserID { get; set; }
    }
}
