	<? include "inc_0302.php"; ?>
	<? if(!$_SESSION[masterSession]){ ?>
	<tr>
		<td align="right" style="padding:5px 0 0 0">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">			
				<tr>
					<td align="right"><img src="/images/btn/btn_excel.gif" align="absmiddle" onClick="saveToExcel('�����ĽĴ�')" style="cursor:pointer"></td>
				</tr>
			</table>			
		</td>
	</tr>
	<tr>
		<td style="padding:5px 0px 0px 5px">- <strong>�ʱ�������</strong>�� 10�� �� ���·�,<br>
			- <strong>�߱�������</strong>�� ��� �߰� ���� 5-6�� ������, <br>
			- <strong>�ı�������</strong>�� �׺��� ���� �� �ִ� �������� �����˴ϴ�.</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<!---�����깰--->
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="../../images/sub03/box1_top.gif"></td>
				</tr>
				<tr>
					<td background="../../images/member/box3_bg.gif" style="padding:0px 31px 0px 31px">
						<!---ȸ������, ���̵�/��й�ȣã��--->
						<!---ȸ������, ���̵�/��й�ȣã��(e)--->
					</td>
				</tr>
				<tr>
					<td background="../../images/sub03/box1_bg.gif" style="padding:0px 31px 0px 31px">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="20%"><img src="../../images/sub03/img_02.gif"></td>
								<td width="80%" class="text11_gray3"> 
								*�츮 ��깰�� ����� �����縦 ����ϸ� ��ö������ �����մϴ�.<br>
								* ����(������: �ѿ�), �������, �߰��, ��, ��ġ �� ������ �����길�� ����մϴ�.  <br>
								* �Ĵ��� ������ ���� ���� ��ǰ������ ���� �� �� �ֽ��ϴ�. <br>
								* ��ġ�� �������߷� ��������� ���� ��� �����մϴ�.</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><img src="../../images/sub03/box1_bottom.gif"></td>
				</tr>
			</table>
			<!---�����깰(e)--->
		</td>
	</tr>	
	<? }else{ ?>
	<tr>
		<td align="right" style="padding:5 0 0 0">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">			
				<tr>
					<td width="50%" align="left"><img src="/images/btn/btn_excel.gif" align="absmiddle" onClick="saveToExcel('code')" style="cursor:pointer"></td>
					<td width="50%" align="right"><font color="#FF0000">�� �Ĵ� �ۼ��� <b>��¥</b>�� Ŭ���Ͻʽÿ�</font></td>
				</tr>
			</table>			
		</td>
	</tr>
	<? } ?>
</table>