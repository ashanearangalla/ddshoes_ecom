using AutoMapper;
using ddApp.Dto;
using ddApp.Interfaces;
using ddApp.Models;
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
    public class OutletController : ControllerBase
    {
        private readonly IOutletRepository _outletRepository;
        private readonly IMapper _mapper;

        public OutletController(IOutletRepository outletRepository, IMapper mapper)
        {
            _outletRepository = outletRepository;
            _mapper = mapper;
        }

        [HttpGet]
        [ProducesResponseType(200, Type = typeof(IEnumerable<OutletDto>))]
        public IActionResult GetOutlets()
        {
            var outlets = _mapper.Map<List<OutletDto>>(_outletRepository.GetOutlets());

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(outlets);
        }

        [HttpGet("{outletId}")]
        [ProducesResponseType(200, Type = typeof(OutletDto))]
        [ProducesResponseType(400)]
        public IActionResult GetOutlet(int outletId)
        {
            if (!_outletRepository.OutletExists(outletId))
                return NotFound();

            var outlet = _mapper.Map<OutletDto>(_outletRepository.GetOutlet(outletId));

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(outlet);
        }

        [HttpPost]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult CreateOutlet([FromBody] OutletDto outletCreate)
        {
            if (outletCreate == null)
                return BadRequest(ModelState);

            var outlet = _outletRepository.GetOutlets()
                .Where(c => c.OutletName.Trim().ToUpper() == outletCreate.OutletName.TrimEnd().ToUpper())
                .FirstOrDefault();

            if (outlet != null)
            {
                ModelState.AddModelError("", "Outlet already exists");
                return StatusCode(422, ModelState);
            }

            var outletMap = _mapper.Map<Outlet>(outletCreate);

            if (!_outletRepository.CreateOutlet(outletMap))
            {
                ModelState.AddModelError("", "Something went wrong while saving");
                return StatusCode(500, ModelState);
            }

            return Ok("Successfully created");
        }

        [HttpPut("{outletId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult UpdateOutlet(int outletId, [FromBody] OutletDto updatedOutlet)
        {
            if (updatedOutlet == null || outletId != updatedOutlet.OutletID)
                return BadRequest(ModelState);

            if (!_outletRepository.OutletExists(outletId))
                return NotFound();

            var outletMap = _mapper.Map<Outlet>(updatedOutlet);

            if (!_outletRepository.UpdateOutlet(outletMap))
            {
                ModelState.AddModelError("", "Something went wrong while updating");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }

        [HttpDelete("{outletId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult DeleteOutlet(int outletId)
        {
            if (!_outletRepository.OutletExists(outletId))
                return NotFound();

            var outlet = _outletRepository.GetOutlet(outletId);

            if (!_outletRepository.DeleteOutlet(outlet))
            {
                ModelState.AddModelError("", "Something went wrong while deleting");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }
    }
}
