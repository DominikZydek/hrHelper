/**
 * Calculates and returns detailed information about a user's Paid Time Off (PTO) status
 *
 * @param {Object} user - The user object containing PTO-related properties
 * @param {number} user.paid_time_off_days - Total number of PTO days according to contract
 * @param {number} user.working_time - User's working time factor (e.g., 1.0 for full-time, 0.5 for half-time)
 * @param {number} user.pending_pto - Number of PTO days in pending state (awaiting approval)
 * @param {number} user.available_pto - Gross number of PTO days available before subtracting pending days
 *
 * @returns {Object} An object containing calculated PTO information:
 *   - ptoDays: Total contracted PTO days adjusted for working time
 *   - pendingPtoDays: PTO days currently under review in active leave requests
 *   - availablePtoDays: PTO days that can be requested (adjusted for pending requests)
 *   - usedPtoDays: PTO days that have been used already
 */
export const getUserPTOInfo = (user) => {
	const ptoDays = user.paid_time_off_days * user.working_time;
	const pendingPtoDays = user.pending_pto * user.working_time;
	const availablePtoDays = user.available_pto * user.working_time - pendingPtoDays;
	const usedPtoDays = ptoDays - availablePtoDays - pendingPtoDays;
	return {
		ptoDays,
		pendingPtoDays,
		availablePtoDays,
		usedPtoDays
	};
};
