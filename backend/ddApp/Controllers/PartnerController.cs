using AutoMapper;
using ddApp.Dto;
using ddApp.Interfaces;
using ddApp.Models;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;
using System.Linq;

namespace ddApp.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class PartnerController : ControllerBase
    {
        private readonly IPartnerRepository _partnerRepository;
        private readonly IMapper _mapper;

        public PartnerController(IPartnerRepository partnerRepository, IMapper mapper)
        {
            _partnerRepository = partnerRepository;
            _mapper = mapper;
        }

        [HttpGet]
        [ProducesResponseType(200, Type = typeof(IEnumerable<PartnerDto>))]
        public IActionResult GetPartners()
        {
            var partners = _mapper.Map<List<PartnerDto>>(_partnerRepository.GetPartners());

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(partners);
        }

        [HttpGet("{partnerId}")]
        [ProducesResponseType(200, Type = typeof(PartnerDto))]
        [ProducesResponseType(400)]
        public IActionResult GetPartner(int partnerId)
        {
            if (!_partnerRepository.PartnerExists(partnerId))
                return NotFound();

            var partner = _mapper.Map<PartnerDto>(_partnerRepository.GetPartner(partnerId));

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(partner);
        }

        [HttpPost]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult CreatePartner([FromBody] PartnerDto partnerCreate)
        {
            if (partnerCreate == null)
                return BadRequest(ModelState);

            var partner = _partnerRepository.GetPartners()
                .Where(p => p.ContactEmail.Trim().ToUpper() == partnerCreate.ContactEmail.TrimEnd().ToUpper())
                .FirstOrDefault();

            if (partner != null)
            {
                ModelState.AddModelError("", "Partner already exists");
                return StatusCode(422, ModelState);
            }

            var partnerMap = _mapper.Map<Partner>(partnerCreate);

            if (!_partnerRepository.CreatePartner(partnerMap))
            {
                ModelState.AddModelError("", "Something went wrong while saving");
                return StatusCode(500, ModelState);
            }

            return Ok("Successfully created");
        }

        [HttpPut("{partnerId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult UpdatePartner(int partnerId, [FromBody] PartnerDto updatedPartner)
        {
            if (updatedPartner == null || partnerId != updatedPartner.PartnerID)
                return BadRequest(ModelState);

            if (!_partnerRepository.PartnerExists(partnerId))
                return NotFound();

            var partnerMap = _mapper.Map<Partner>(updatedPartner);

            if (!_partnerRepository.UpdatePartner(partnerMap))
            {
                ModelState.AddModelError("", "Something went wrong while updating");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }

        [HttpDelete("{partnerId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult DeletePartner(int partnerId)
        {
            if (!_partnerRepository.PartnerExists(partnerId))
                return NotFound();

            var partner = _partnerRepository.GetPartner(partnerId);

            if (!_partnerRepository.DeletePartner(partner))
            {
                ModelState.AddModelError("", "Something went wrong while deleting");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }
    }
}