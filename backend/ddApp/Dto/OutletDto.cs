namespace ddApp.Dto
{
    public class OutletDto
    {
        public int OutletID { get; set; }
        public string OutletName { get; set; }
        public string Location { get; set; }

        // Foreign key to User
        public int UserID { get; set; }
    }
}
